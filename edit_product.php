<?php
$page_title = 'Edit items';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);
?>
<?php
$product = find_by_id('products', (int) $_GET['id']);
$all_shelves = find_all('shelves');
$all_photo = find_all('media');
if (!$product) {
  $session->msg("d", "Missing product id.");
  redirect('product.php');
}
?>
<?php
if (isset($_POST['product'])) {
  $req_fields = array('product-title', 'product-shelf', 'product-quantity');
  validate_fields($req_fields);

  if (empty($errors)) {
    // Sanitizar entrada para BD
    $p_name = $db->escape(trim($_POST['product-title']));
    $p_shelf = (int) $_POST['product-shelf'];
    $p_qty = (int) $_POST['product-quantity'];
    $p_note = $db->escape(trim($_POST['product-note']));

    if (empty($_POST['product-photo'])) {
      $media_id = "NULL";
    } else {
      $media_id = (int) $_POST['product-photo'];
    }

    $query = "UPDATE products SET";
    $query .= " name ='{$p_name}', quantity ='{$p_qty}',";
    $query .= " shelf_id ='{$p_shelf}', media_id={$media_id}, note='{$p_note}'";
    $query .= " WHERE id ='{$product['id']}'";

    $result = $db->query($query);
    if ($result) {
      $product_id = $product['id'];
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
      $session->msg('s', "Producto ha sido actualizado. ");
      redirect('product.php', false);
    } else {
      $session->msg('d', ' Lo siento, actualización falló.');
      redirect('edit_product.php?id=' . $product['id'], false);
    }

  } else {
    $session->msg("d", $errors);
    redirect('edit_product.php?id=' . $product['id'], false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>Edit item</span>
      </strong>
    </div>
    <div class="panel-body">
      <div class="col-md-7">
        <form method="post" action="edit_product.php?id=<?php echo (int) $product['id'] ?>"
          enctype="multipart/form-data">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-th-large"></i>
              </span>
              <input type="text" class="form-control" name="product-title"
                value="<?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?>">
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <select class="form-control" name="product-shelf">
                  <option value="">Select Shelf</option>
                  <?php foreach ($all_shelves as $shelf): ?>
                    <option value="<?php echo (int) $shelf['id']; ?>" <?php if ($product['shelf_id'] === $shelf['id']):
                          echo "selected";
                        endif; ?>>
                      <?php echo htmlspecialchars($shelf['name'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-6">
                <select class="form-control" name="product-photo">
                  <option value=""> Without image</option>
                  <?php foreach ($all_photo as $photo): ?>
                    <option value="<?php echo (int) $photo['id']; ?>" <?php if ($product['media_id'] == $photo['id']):
                          echo "selected";
                        endif; ?>>
                      <?php echo htmlspecialchars($photo['file_name'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-shopping-cart"></i>
                  </span>
                  <input type="text" class="form-control" name="product-quantity"
                    value="<?php echo htmlspecialchars($product['quantity'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
              </div>
              <div class="col-md-8">
                <label>Upload images:</label>
                <input type="file" name="product-images[]" multiple class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Note:</label>
            <textarea class="form-control" name="product-note" placeholder="Optional note"
              rows="3"><?php echo htmlspecialchars($product['note'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
          </div>
          <button type="submit" name="product" class="btn btn-danger">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>