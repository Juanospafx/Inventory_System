<?php
$page_title = 'Add item to inventory';
require_once(__DIR__ . '/../includes/load.php');
require_once(__DIR__ . '/../vendor/autoload.php');
page_require_level(2);

$all_shelves = find_all('shelves');

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

$catalog_items = find_by_sql("SELECT id, name, catalog_code, catalog_category, quantity, qr_code FROM products ORDER BY name ASC");

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
                  <option value="<?php echo (int)$item['id']; ?>" data-category="<?php echo htmlspecialchars($cat, ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo htmlspecialchars($item['name']); ?><?php echo $code !== '' ? ' (' . htmlspecialchars($code) . ')' : ''; ?><?php echo $cat !== '' ? ' — [' . htmlspecialchars($cat) . ']' : ''; ?>
                  </option>
                <?php endforeach; ?>
              </select>
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
              <label class="form-label">Category name</label>
              <input type="text" class="form-control" name="catalog-category-name" id="catalog-category-name" placeholder="Type category name">
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Choose existing category (optional)</label>
              <input list="catalog-categories-list" class="form-control" id="catalog-category-picker" placeholder="Pick existing category">
              <datalist id="catalog-categories-list">
                <?php foreach ($catalog_categories as $cat): ?>
                  <option value="<?php echo htmlspecialchars((string)$cat['name'], ENT_QUOTES, 'UTF-8'); ?>"></option>
                <?php endforeach; ?>
              </datalist>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Upload images (for new item)</label>
              <input type="file" name="product-images[]" multiple class="form-control">
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
              <select class="form-control" name="product-shelf">
                <option value="">No shelf assigned</option>
                <?php foreach ($all_shelves as $shelf): ?>
                  <option value="<?php echo (int)$shelf['id']; ?>"><?php echo htmlspecialchars($shelf['name']); ?></option>
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
  const categoryPickerEl = document.getElementById('catalog-category-picker');
  if (!searchEl || !catEl || !selectEl || !newNameEl) return;

  const originalOptions = Array.from(selectEl.options).map(opt => ({
    value: opt.value,
    text: opt.text,
    category: (opt.dataset && opt.dataset.category) ? opt.dataset.category : ''
  }));

  function toggleNewItemInputs() {
    const hasExisting = !!selectEl.value;
    newNameEl.disabled = hasExisting;
    if (hasExisting) newNameEl.value = '';
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
      selectEl.appendChild(el);
    });

    if (Array.from(selectEl.options).some(x => x.value === current)) {
      selectEl.value = current;
    }

    toggleNewItemInputs();
  }

  searchEl.addEventListener('input', applyFilter);
  catEl.addEventListener('change', applyFilter);
  selectEl.addEventListener('change', toggleNewItemInputs);

  if (categoryPickerEl && categoryNameEl) {
    categoryPickerEl.addEventListener('change', function(){
      if (this.value) categoryNameEl.value = this.value;
    });
  }

  applyFilter();
})();
</script>

<?php include_once(__DIR__ . '/../views/footer.php'); ?>
