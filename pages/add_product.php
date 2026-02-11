﻿<?php
$page_title = 'Add item';
require_once(__DIR__ . '/../includes/load.php');
require_once(__DIR__ . '/../vendor/autoload.php');
page_require_level(2);



if (isset($_POST['add_product'])) {
  $req_fields = array('product-title', 'product-shelf', 'product-quantity');
  validate_fields($req_fields);

  if (empty($errors)) {
    // Sanitizar datos de entrada para BD (sin remove_junk)
    $p_name = $db->escape(trim($_POST['product-title']));
    $p_shelf = (int) $_POST['product-shelf'];
    $p_qty = (int) $_POST['product-quantity'];
    $p_note = $db->escape(trim($_POST['product-note']));
    $date = make_date();

    $query = "INSERT INTO products (name, quantity, shelf_id, date, note) 
                  VALUES ('{$p_name}', '{$p_qty}', '{$p_shelf}', '{$date}', '{$p_note}')";

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
            <!-- Nombre del producto -->
            <div class="form-group">
              <label>Item name:</label>
              <input type="text" class="form-control" name="product-title" placeholder="Name" maxlength="50"
                value="<?php echo isset($form_data['product-title']) ? htmlspecialchars($form_data['product-title'], ENT_QUOTES, 'UTF-8') : ''; ?>">
            </div>

            <!-- Formulario de subida de m??ltiples im??genes -->
            <div class="form-group">
              <label>Upload images:</label>
              <input type="file" name="product-images[]" multiple class="form-control">
            </div>

            <!-- Selecci??n de Anaquel -->
            <div class="form-group">
              <label>Shelf:</label>
              <select class="form-control select2" name="product-shelf">
                <option value="">Select a Shelf</option>
                <?php foreach ($all_shelves as $shelf): ?>
                  <?php $selected = (isset($form_data['product-shelf']) && $form_data['product-shelf'] == $shelf['id']) ? 'selected' : ''; ?>
                  <option value="<?php echo (int) $shelf['id']; ?>" <?php echo $selected; ?>>
                    <?php echo htmlspecialchars($shelf['name'], ENT_QUOTES, 'UTF-8'); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>



            <!-- Cantidad -->
            <div class="form-group">
              <label>Quantity:</label>
              <input type="number" class="form-control" name="product-quantity" placeholder="123..."
                value="<?php echo isset($form_data['product-quantity']) ? htmlspecialchars($form_data['product-quantity'], ENT_QUOTES, 'UTF-8') : ''; ?>">
            </div>

            <!-- Nota -->
            <div class="form-group">
              <label>Note:</label>
              <textarea class="form-control" name="product-note" placeholder="Optional note"
                rows="3"><?php echo isset($form_data['product-note']) ? htmlspecialchars($form_data['product-note'], ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
            </div>



            <button type="submit" name="add_product" class="btn btn-danger">Add item</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once(__DIR__ . '/../views/footer.php'); ?>
