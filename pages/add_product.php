<?php
$page_title = 'Add item';
require_once(__DIR__ . '/../includes/load.php');
require_once(__DIR__ . '/../vendor/autoload.php');
page_require_level(2);



if (isset($_POST['add_product'])) {
  $req_fields = array('product-title', 'product-quantity');
  validate_fields($req_fields);

  if (empty($errors)) {
    // Sanitizar datos de entrada para BD (sin remove_junk)
    $p_name = $db->escape(trim($_POST['product-title']));
    $p_shelf = isset($_POST['product-shelf']) && $_POST['product-shelf'] !== '' ? (int) $_POST['product-shelf'] : null;
    $p_qty = (int) $_POST['product-quantity'];
    $p_note = $db->escape(trim($_POST['product-note']));
    $p_category_id = isset($_POST['catalog-category-id']) && $_POST['catalog-category-id'] !== '' ? (int) $_POST['catalog-category-id'] : null;
    $p_category_name = $db->escape(trim($_POST['catalog-category-name'] ?? ''));
    $date = make_date();

    if ($p_category_id === null && $p_category_name !== '' && tableExists('catalog_categories')) {
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
    $p_category_name_sql = $p_category_name !== '' ? "'{$p_category_name}'" : "NULL";
    $p_shelf_sql = $p_shelf ? "'{$p_shelf}'" : "NULL";

    $query = "INSERT INTO products (name, quantity, shelf_id, catalog_category_id, catalog_category, date, note) 
                  VALUES ('{$p_name}', '{$p_qty}', {$p_shelf_sql}, {$p_category_id_sql}, {$p_category_name_sql}, '{$date}', '{$p_note}')";

    if ($db->query($query)) {
      $product_id = $db->insert_id();

      // Generate QR Code using API
      $qr_content = 'PROD-' . str_pad($product_id, 8, '0', STR_PAD_LEFT); // Or whatever content you want
      $qr_api_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qr_content);
      $qr_image = file_get_contents($qr_api_url);

      $qr_dir_fs = APP_ROOT . DS . 'uploads' . DS . 'qrcodes' . DS;
      if (!is_dir($qr_dir_fs)) {
        mkdir($qr_dir_fs, 0777, true);
      }
      $qr_rel_path = 'uploads/qrcodes/qrcode-' . $product_id . '.png';
      $qr_path = $qr_dir_fs . 'qrcode-' . $product_id . '.png';
      file_put_contents($qr_path, $qr_image);

      $update_query = "UPDATE products SET qr_code='{$db->escape($qr_rel_path)}' WHERE id='{$product_id}'";
      $db->query($update_query);

      if (isset($_FILES['product-images']) && !empty(array_filter($_FILES['product-images']['name']))) {
        $media = new Media();
        $media_files = $media->uploadMultiple($_FILES['product-images'], [], true);
        $first_id = null;
        foreach ($media_files as $media_file) {
          if (isset($media_file['id'])) {
            if (is_null($first_id)) {
              $first_id = (int) $media_file['id'];
            }
            $sql_product_media = "INSERT INTO product_media (product_id, media_id) VALUES ('{$product_id}', '{$media_file['id']}')";
            $db->query($sql_product_media);
          }
        }
        if ($first_id) {
          $db->query("UPDATE products SET media_id='{$first_id}' WHERE id='{$product_id}'");
        }
      }

      $session->msg('s', "Product added successfully. The QR code has been generated.");
      redirect('add_product.php', false);
    } else {
      $session->msg('d', 'Error adding the product: ' . $db->error);
      $_SESSION['form_data'] = $_POST;
      redirect('add_product.php', false);
    }
  } else {
    $_SESSION['form_data'] = $_POST;
    $session->msg('d', $errors);
    redirect('add_product.php', false);
  }
}

$all_shelves = find_all('shelves');
$catalog_categories = find_by_sql("SELECT DISTINCT name FROM (
  SELECT TRIM(name) AS name FROM catalog_categories
  UNION
  SELECT TRIM(catalog_category) AS name FROM products
) t
WHERE name IS NOT NULL AND name <> ''
ORDER BY name ASC");
$prefill_category = trim((string)($_GET['category'] ?? ''));

// Lógica para filtrar anaqueles si viene del mapa
if (isset($_GET['shelf_filter'])) {
    $filter = strtoupper($_GET['shelf_filter']);
    $filtered_shelves = [];
    foreach ($all_shelves as $shelf) {
        // Verifica si el nombre del anaquel comienza con la letra del filtro (ej: 'A' coincide con 'A1', 'A2', etc.)
        if (strpos(strtoupper($shelf['name']), $filter) === 0) {
            $filtered_shelves[] = $shelf;
        }
    }
    $all_shelves = $filtered_shelves;
}
?>

<?php include_once(__DIR__ . '/../views/header.php'); ?>

<?php
// Recuperar datos del formulario guardados en la sesi??n, si existen, y luego limpiarlos
$form_data = array();
if (isset($_SESSION['form_data'])) {
  $form_data = $_SESSION['form_data'];
  unset($_SESSION['form_data']);
}
?>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-9">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <i class="fa-solid fa-plus"></i>
          <span>Add Item</span>
        </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-12">
          <form id="add-product-form" method="post" action="add_product.php" class="clearfix"
            enctype="multipart/form-data">
            
            <div class="row">
              <!-- Nombre del producto -->
              <div class="col-md-6 mb-3">
                <label class="form-label">Item name:</label>
                <input type="text" class="form-control" name="product-title" placeholder="Name" maxlength="50"
                  value="<?php echo isset($form_data['product-title']) ? htmlspecialchars($form_data['product-title'], ENT_QUOTES, 'UTF-8') : ''; ?>">
              </div>

              <!-- Categoría -->
              <div class="col-md-6 mb-3">
                <label class="form-label">Category:</label>
                <select class="form-control" id="catalog-category-select">
                  <option value="">Select existing category (optional)</option>
                  <?php foreach ($catalog_categories as $cat): ?>
                    <?php $catName = (string)$cat['name']; ?>
                    <option value="<?php echo htmlspecialchars($catName, ENT_QUOTES, 'UTF-8'); ?>" <?php echo ($prefill_category !== '' && strcasecmp($prefill_category, $catName) === 0) ? 'selected' : ''; ?>><?php echo htmlspecialchars($catName, ENT_QUOTES, 'UTF-8'); ?></option>
                  <?php endforeach; ?>
                </select>
                <input type="hidden" name="catalog-category-id" value="">
                <input type="text" class="form-control mt-2" name="catalog-category-name" id="catalog-category-name" placeholder="If new category, type it here" value="">
              </div>
            </div>

            <div class="row">
              <!-- Cantidad -->
              <div class="col-md-6 mb-3">
                <label class="form-label">Quantity:</label>
                <input type="number" class="form-control" name="product-quantity" placeholder="123..."
                  value="<?php echo isset($form_data['product-quantity']) ? htmlspecialchars($form_data['product-quantity'], ENT_QUOTES, 'UTF-8') : ''; ?>">
              </div>

              <!-- Anaquel (Opcional) -->
              <div class="col-md-6 mb-3">
                <label class="form-label">Shelf (optional):</label>
                <select class="form-control select2" name="product-shelf">
                  <option value="">No shelf assigned</option>
                  <?php foreach ($all_shelves as $shelf): ?>
                    <?php $selected = (isset($form_data['product-shelf']) && $form_data['product-shelf'] == $shelf['id']) ? 'selected' : ''; ?>
                    <option value="<?php echo (int) $shelf['id']; ?>" <?php echo $selected; ?>>
                      <?php echo htmlspecialchars($shelf['name'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <!-- Formulario de subida de múltiples imágenes -->
              <div class="col-md-6 mb-3">
                <label class="form-label">Upload images:</label>
                <input type="file" name="product-images[]" multiple class="form-control">
              </div>
            </div>

            <!-- Nota -->
            <div class="mb-3">
              <label class="form-label">Note:</label>
              <textarea class="form-control" name="product-note" placeholder="Optional note"
                rows="3"><?php echo isset($form_data['product-note']) ? htmlspecialchars($form_data['product-note'], ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
            </div>



            <small class="text-muted d-block mb-2">Tip: category is required for catalog flow. Shelf is optional.</small>
            <button type="submit" name="add_product" class="btn btn-primary">Add item</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  (function(){
    var sel = document.getElementById('catalog-category-select');
    var input = document.getElementById('catalog-category-name');
    var form = document.getElementById('add-product-form');
    if(!sel || !input || !form) return;

    sel.addEventListener('change', function(){
      // Keep input for truly new categories; don't duplicate existing ones visually
      if (this.value && !input.value.trim()) {
        input.value = this.value;
      }
    });

    form.addEventListener('submit', function(){
      // If user selected existing category and left input empty, submit selected category name
      if (!input.value.trim() && sel.value) {
        input.value = sel.value;
      }
    });
  })();
</script>

<?php include_once(__DIR__ . '/../views/footer.php'); ?>
