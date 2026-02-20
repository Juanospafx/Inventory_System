<?php
$page_title = 'Add item to inventory';
require_once(__DIR__ . '/../includes/load.php');
require_once(__DIR__ . '/../vendor/autoload.php');
page_require_level(2);

$all_shelves = find_all('shelves');
$prefill_shelf_filter = isset($_GET['shelf_filter']) ? strtoupper(trim((string)$_GET['shelf_filter'])) : '';
$prefill_shelf_id = '';
if ($prefill_shelf_filter !== '') {
  foreach ($all_shelves as $s) {
    $sn = strtoupper((string)$s['name']);
    if (strpos($sn, $prefill_shelf_filter) === 0) {
      $prefill_shelf_id = (string)$s['id'];
      break;
    }
  }
}

if (tableExists('catalog_categories')) {
  $catalog_categories = find_by_sql("SELECT DISTINCT name FROM (
    SELECT TRIM(name) AS name FROM catalog_categories
    UNION
    SELECT TRIM(catalog_category) AS name FROM products
  ) t
  WHERE name IS NOT NULL AND name <> ''
  ORDER BY name ASC");
} else {
  $catalog_categories = find_by_sql("SELECT DISTINCT TRIM(catalog_category) AS name FROM products WHERE catalog_category IS NOT NULL AND catalog_category <> '' ORDER BY catalog_category ASC");
}

$catalog_items = find_by_sql("SELECT p.id, p.name, p.catalog_code, p.catalog_category, p.quantity, p.qr_code, m.file_name AS image
  FROM products p
  LEFT JOIN media m ON p.media_id = m.id
  ORDER BY p.name ASC");

function ensure_product_qr($productId)
{
  global $db;
  $productId = (int)$productId;
  if ($productId <= 0) return;

  $res = $db->query("SELECT qr_code FROM products WHERE id = '{$productId}' LIMIT 1");
  $row = $db->fetch_assoc($res);
  $current = isset($row['qr_code']) ? trim((string)$row['qr_code']) : '';

  $qr_rel_path = 'uploads/qrcodes/qrcode-' . $productId . '.png';
  $qr_path = APP_ROOT . DS . 'uploads' . DS . 'qrcodes' . DS . 'qrcode-' . $productId . '.png';

  if ($current !== '' && file_exists(APP_ROOT . DS . $current)) {
    return;
  }

  $qr_content = 'PROD-' . str_pad((string)$productId, 8, '0', STR_PAD_LEFT);
  $qr_api_url = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($qr_content);

  if (!is_dir(dirname($qr_path))) {
    @mkdir(dirname($qr_path), 0777, true);
  }

  $qr_image = false;
  if (function_exists('curl_init')) {
    $ch = curl_init($qr_api_url);
    if ($ch) {
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, 8);
      $resp = curl_exec($ch);
      $http = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);
      if ($http >= 200 && $http < 300 && $resp !== false) {
        $qr_image = $resp;
      }
    }
  }

  if ($qr_image === false) {
    $fg = @file_get_contents($qr_api_url);
    if ($fg !== false) {
      $qr_image = $fg;
    }
  }

  if ($qr_image !== false) {
    @file_put_contents($qr_path, $qr_image);
    $db->query("UPDATE products SET qr_code='" . $db->escape($qr_rel_path) . "' WHERE id='{$productId}' LIMIT 1");
  }
}

if (isset($_POST['add_product'])) {
  $existingProductId = (int)($_POST['existing-product-id'] ?? 0);
  $qty = (int)($_POST['product-quantity'] ?? 0);
  $shelfId = isset($_POST['product-shelf']) && $_POST['product-shelf'] !== '' ? (int)$_POST['product-shelf'] : null;
  $noteRaw = trim((string)($_POST['product-note'] ?? ''));
  $note = $db->escape($noteRaw);

  if ($qty <= 0) {
    $session->msg('d', 'Quantity must be greater than 0.');
    redirect('add_product.php', false);
  }

  // Mode A: add stock to existing catalog item
  if ($existingProductId > 0) {
    $existing = find_by_id('products', $existingProductId);
    if (!$existing) {
      $session->msg('d', 'Selected catalog item does not exist.');
      redirect('add_product.php', false);
    }

    $sql = "UPDATE products SET quantity = quantity + '{$qty}'";
    if ($shelfId) {
      $sql .= ", shelf_id = '{$shelfId}'";
    }
    if ($noteRaw !== '') {
      $sql .= ", note = '{$note}'";
    }
    $sql .= " WHERE id = '{$existingProductId}' LIMIT 1";

    if ($db->query($sql)) {
      ensure_product_qr($existingProductId);
      $session->msg('s', 'Inventory updated from catalog item successfully.');
      redirect('add_product.php', false);
    }

    $session->msg('d', 'Error updating inventory item.');
    redirect('add_product.php', false);
  }

  // Mode B: create new item (also becomes catalog item)
  $nameRaw = trim((string)($_POST['product-title'] ?? ''));
  if ($nameRaw === '') {
    $session->msg('d', 'Item name is required when creating a new item.');
    redirect('add_product.php', false);
  }

  $p_name = $db->escape($nameRaw);
  $p_category_name_raw = trim((string)($_POST['catalog-category-name'] ?? ''));
  $p_category_name = $db->escape($p_category_name_raw);
  $date = make_date();

  $p_category_id = null;
  if ($p_category_name_raw !== '' && tableExists('catalog_categories')) {
    $exists = $db->query("SELECT id FROM catalog_categories WHERE name = '{$p_category_name}' LIMIT 1");
    $rowCat = $db->fetch_assoc($exists);
    if ($rowCat) {
      $p_category_id = (int)$rowCat['id'];
    } else {
      $db->query("INSERT INTO catalog_categories (name, is_active) VALUES ('{$p_category_name}', 1)");
      $p_category_id = (int)$db->insert_id();
    }
  }

  $p_category_id_sql = $p_category_id ? (string)$p_category_id : "NULL";
  $p_category_name_sql = $p_category_name_raw !== '' ? "'{$p_category_name}'" : "NULL";
  $p_shelf_sql = $shelfId ? "'{$shelfId}'" : "NULL";
  $p_note_sql = $noteRaw !== '' ? "'{$note}'" : "NULL";

  $query = "INSERT INTO products (name, quantity, shelf_id, catalog_category_id, catalog_category, date, note)
            VALUES ('{$p_name}', '{$qty}', {$p_shelf_sql}, {$p_category_id_sql}, {$p_category_name_sql}, '{$date}', {$p_note_sql})";

  if ($db->query($query)) {
    $product_id = $db->insert_id();

    ensure_product_qr($product_id);

    if (isset($_FILES['product-images']) && !empty(array_filter($_FILES['product-images']['name']))) {
      $media = new Media();
      $media_files = $media->uploadMultiple($_FILES['product-images'], [], true);
      $first_id = null;
      foreach ($media_files as $media_file) {
        if (isset($media_file['id'])) {
          if (is_null($first_id)) {
            $first_id = (int)$media_file['id'];
          }
          $sql_product_media = "INSERT INTO product_media (product_id, media_id) VALUES ('{$product_id}', '{$media_file['id']}')";
          $db->query($sql_product_media);
        }
      }
      if ($first_id) {
        $db->query("UPDATE products SET media_id='{$first_id}' WHERE id='{$product_id}'");
      }
    }

    $session->msg('s', 'New inventory item created (and added to catalog).');
    redirect('add_product.php', false);
  }

  $session->msg('d', 'Error adding the product: ' . $db->error);
  redirect('add_product.php', false);
}
?>

<?php include_once(__DIR__ . '/../views/header.php'); ?>

<div class="row"><div class="col-md-12"><?php echo display_msg($msg); ?></div></div>

<div class="row">
  <div class="col-md-10">
    <div class="panel panel-default">
      <div class="panel-heading"><strong><i class="fa-solid fa-plus"></i> <span>Add item to inventory</span></strong></div>
      <div class="panel-body">
        <form id="add-product-form" method="post" action="add_product.php" class="clearfix" enctype="multipart/form-data">

          <h5 class="mb-3">1) Choose from catalog</h5>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Find item (by name/code)</label>
              <input type="text" id="catalog_search" class="form-control" placeholder="Type to filter items...">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Filter by category</label>
              <select id="catalog_category_filter" class="form-control">
                <option value="">All categories</option>
                <?php foreach ($catalog_categories as $cat): ?>
                  <option value="<?php echo htmlspecialchars((string)$cat['name'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars((string)$cat['name']); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Select item from catalog (optional)</label>
              <select class="form-control" name="existing-product-id" id="existing_product_id">
                <option value="">No product selected (use section 2 to create new)</option>
                <?php foreach ($catalog_items as $item): ?>
                  <?php $cat = (string)($item['catalog_category'] ?? ''); ?>
                  <?php $code = (string)($item['catalog_code'] ?? ''); ?>
                  <?php $imgName = (string)($item['image'] ?? ''); ?>
                  <?php $imgUrl = $imgName !== '' ? base_url('uploads/products/' . $imgName) : base_url('uploads/products/no_image.jpg'); ?>
                  <option value="<?php echo (int)$item['id']; ?>" data-category="<?php echo htmlspecialchars($cat, ENT_QUOTES, 'UTF-8'); ?>" data-image-url="<?php echo htmlspecialchars($imgUrl, ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo htmlspecialchars($item['name']); ?><?php echo $code !== '' ? ' (' . htmlspecialchars($code) . ')' : ''; ?><?php echo $cat !== '' ? ' — [' . htmlspecialchars($cat) . ']' : ''; ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <div id="catalog-item-preview" class="well" style="display:none;margin-top:10px;">
                <div style="font-weight:600;margin-bottom:6px;">Preview del item del catálogo</div>
                <img id="catalog-item-preview-image" src="<?php echo base_url('uploads/products/no_image.jpg'); ?>" alt="Catalog item preview" style="max-width:180px;max-height:180px;object-fit:contain;border:1px solid #ddd;border-radius:6px;padding:4px;background:#fff;">
                <div id="catalog-item-preview-name" style="margin-top:6px;color:#555;"></div>
              </div>
            </div>
          </div>

          <hr>
          <h5 class="mb-3">2) Create new item (if not in catalog)</h5>
          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label">Item name</label>
              <input type="text" class="form-control" name="product-title" id="product-title" placeholder="Name">
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Choose existing category</label>
              <select class="form-control" id="catalog-category-select-existing">
                <option value="">Select category...</option>
                <?php foreach ($catalog_categories as $cat): ?>
                  <option value="<?php echo htmlspecialchars((string)$cat['name'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars((string)$cat['name']); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4 mb-3 d-flex align-items-end">
              <button type="button" class="btn btn-outline-info w-100" id="toggle-new-category-btn">Crear categoría nueva</button>
            </div>

            <div class="col-md-6 mb-3" id="new-category-wrapper" style="display:none;">
              <label class="form-label">New category name</label>
              <input type="text" class="form-control" id="new-category-input" placeholder="Type new category name">
            </div>

            <input type="hidden" name="catalog-category-name" id="catalog-category-name" value="">

            <div class="col-md-6 mb-3">
              <label class="form-label">Upload images (for new item)</label>
              <input type="file" name="product-images[]" id="product-images" multiple class="form-control" accept="image/*">
              <div id="new-item-images-preview" style="display:none;margin-top:10px;">
                <div style="font-weight:600;margin-bottom:6px;">Preview de imágenes nuevas</div>
                <div id="new-item-images-preview-grid" style="display:flex;flex-wrap:wrap;gap:8px;"></div>
              </div>
            </div>
          </div>

          <hr>
          <h5 class="mb-3">3) General info (applies to both flows)</h5>
          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label">Quantity (required)</label>
              <input type="number" class="form-control" name="product-quantity" min="1" placeholder="123..." required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Shelf (optional)</label>
              <?php if ($prefill_shelf_filter !== ''): ?>
                <div class="mb-1"><span class="badge bg-info text-dark">Preselected from map: <?php echo htmlspecialchars($prefill_shelf_filter); ?></span></div>
              <?php endif; ?>
              <select class="form-control" name="product-shelf">
                <option value="">No shelf assigned</option>
                <?php foreach ($all_shelves as $shelf): ?>
                  <?php $sel = ($prefill_shelf_id !== '' && $prefill_shelf_id == (string)$shelf['id']) ? 'selected' : ''; ?>
                  <option value="<?php echo (int)$shelf['id']; ?>" <?php echo $sel; ?>><?php echo htmlspecialchars($shelf['name']); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Note</label>
              <textarea class="form-control" name="product-note" placeholder="Optional note" rows="1"></textarea>
            </div>
          </div>

          <button type="submit" name="add_product" class="btn btn-primary">Add item to inventory</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const searchEl = document.getElementById('catalog_search');
  const catEl = document.getElementById('catalog_category_filter');
  const selectEl = document.getElementById('existing_product_id');
  const newNameEl = document.getElementById('product-title');
  const categoryNameEl = document.getElementById('catalog-category-name');
  const categorySelectExistingEl = document.getElementById('catalog-category-select-existing');
  const toggleNewCategoryBtn = document.getElementById('toggle-new-category-btn');
  const newCategoryWrapper = document.getElementById('new-category-wrapper');
  const newCategoryInput = document.getElementById('new-category-input');
  const catalogPreviewWrap = document.getElementById('catalog-item-preview');
  const catalogPreviewImage = document.getElementById('catalog-item-preview-image');
  const catalogPreviewName = document.getElementById('catalog-item-preview-name');
  const productImagesInput = document.getElementById('product-images');
  const newImagesPreviewWrap = document.getElementById('new-item-images-preview');
  const newImagesPreviewGrid = document.getElementById('new-item-images-preview-grid');
  if (!searchEl || !catEl || !selectEl || !newNameEl || !categoryNameEl) return;

  const originalOptions = Array.from(selectEl.options).map(opt => ({
    value: opt.value,
    text: opt.text,
    category: (opt.dataset && opt.dataset.category) ? opt.dataset.category : '',
    imageUrl: (opt.dataset && opt.dataset.imageUrl) ? opt.dataset.imageUrl : ''
  }));

  function toggleNewItemInputs() {
    const hasExisting = !!selectEl.value;
    newNameEl.disabled = hasExisting;
    if (hasExisting) newNameEl.value = '';
  }

  function updateCatalogPreview() {
    if (!catalogPreviewWrap || !catalogPreviewImage || !catalogPreviewName) return;
    const opt = selectEl.options[selectEl.selectedIndex];
    if (!opt || !opt.value) {
      catalogPreviewWrap.style.display = 'none';
      return;
    }
    catalogPreviewWrap.style.display = 'block';
    catalogPreviewImage.src = opt.dataset.imageUrl || '<?php echo base_url('uploads/products/no_image.jpg'); ?>';
    catalogPreviewImage.onerror = function() {
      this.onerror = null;
      this.src = '<?php echo base_url('uploads/products/no_image.jpg'); ?>';
    };
    catalogPreviewName.textContent = opt.text || '';
  }

  function renderNewImagesPreview() {
    if (!productImagesInput || !newImagesPreviewWrap || !newImagesPreviewGrid) return;
    const files = Array.from(productImagesInput.files || []);
    newImagesPreviewGrid.innerHTML = '';
    if (!files.length) {
      newImagesPreviewWrap.style.display = 'none';
      return;
    }

    newImagesPreviewWrap.style.display = 'block';
    files.forEach(function(file){
      if (!file.type || file.type.indexOf('image/') !== 0) return;
      const item = document.createElement('div');
      item.style.width = '110px';
      const img = document.createElement('img');
      img.src = URL.createObjectURL(file);
      img.style.width = '110px';
      img.style.height = '110px';
      img.style.objectFit = 'cover';
      img.style.border = '1px solid #ddd';
      img.style.borderRadius = '6px';
      img.onload = function(){ URL.revokeObjectURL(this.src); };

      const cap = document.createElement('div');
      cap.style.fontSize = '11px';
      cap.style.marginTop = '4px';
      cap.style.wordBreak = 'break-word';
      cap.textContent = file.name;

      item.appendChild(img);
      item.appendChild(cap);
      newImagesPreviewGrid.appendChild(item);
    });
  }

  function applyFilter() {
    const q = (searchEl.value || '').toLowerCase();
    const cat = (catEl.value || '').toLowerCase();
    const current = selectEl.value;

    selectEl.innerHTML = '';
    const placeholder = document.createElement('option');
    placeholder.value = '';
    placeholder.text = 'No product selected (create new below)';
    selectEl.appendChild(placeholder);

    originalOptions.forEach(o => {
      if (!o.value) return;
      const text = (o.text || '').toLowerCase();
      const oc = (o.category || '').toLowerCase();
      if (q && text.indexOf(q) === -1) return;
      if (!q && cat && oc !== cat) return;
      const el = document.createElement('option');
      el.value = o.value;
      el.text = o.text;
      el.dataset.category = o.category;
      if (o.imageUrl) {
        el.dataset.imageUrl = o.imageUrl;
      }
      selectEl.appendChild(el);
    });

    if (Array.from(selectEl.options).some(x => x.value === current)) {
      selectEl.value = current;
    }

    toggleNewItemInputs();
    updateCatalogPreview();
  }

  function syncCategoryTarget() {
    const usingNew = newCategoryWrapper && newCategoryWrapper.style.display !== 'none';
    if (usingNew && newCategoryInput) {
      categoryNameEl.value = (newCategoryInput.value || '').trim();
    } else if (categorySelectExistingEl) {
      categoryNameEl.value = (categorySelectExistingEl.value || '').trim();
    }
  }

  searchEl.addEventListener('input', applyFilter);
  catEl.addEventListener('change', applyFilter);
  selectEl.addEventListener('change', function(){
    toggleNewItemInputs();
    updateCatalogPreview();
  });

  if (categorySelectExistingEl) {
    categorySelectExistingEl.addEventListener('change', syncCategoryTarget);
  }

  if (toggleNewCategoryBtn && newCategoryWrapper) {
    toggleNewCategoryBtn.addEventListener('click', function(){
      const isHidden = newCategoryWrapper.style.display === 'none';
      newCategoryWrapper.style.display = isHidden ? 'block' : 'none';
      toggleNewCategoryBtn.textContent = isHidden ? 'Usar categoría existente' : 'Crear categoría nueva';
      syncCategoryTarget();
    });
  }

  if (newCategoryInput) {
    newCategoryInput.addEventListener('input', syncCategoryTarget);
  }

  if (productImagesInput) {
    productImagesInput.addEventListener('change', renderNewImagesPreview);
  }

  const form = document.getElementById('add-product-form');
  if (form) {
    form.addEventListener('submit', function(){
      syncCategoryTarget();
    });
  }

  syncCategoryTarget();
  applyFilter();
  updateCatalogPreview();
  renderNewImagesPreview();
})();
</script>

<?php include_once(__DIR__ . '/../views/footer.php'); ?>
