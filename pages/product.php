﻿<?php
$page_title = 'Items in inventory';
require_once(__DIR__ . '/../includes/load.php');
page_require_level(2);

// Solo items realmente en inventario (con stock > 0)
$products_all = join_product_table();

if (isset($_GET['shelf_filter']) && $_GET['shelf_filter'] !== '') {
  $sf = strtoupper(trim((string)$_GET['shelf_filter']));
  $products_all = array_values(array_filter($products_all, function($p) use ($sf){
    $shelfName = strtoupper((string)($p['shelf'] ?? ''));
    return $shelfName !== '' && strpos($shelfName, $sf) === 0;
  }));
}

$products = array_values(array_filter($products_all, function($p){
  return (int)($p['quantity'] ?? 0) > 0;
}));
?>
<?php include_once(__DIR__ . '/../views/header.php'); ?>

<!-- Campo de b??squeda para filtrado en el cliente -->
<div class="row" style="margin-bottom: 20px;">
  <div class="col-md-12">
    <input id="searchInput" type="text" class="form-control" placeholder="Filter by name, shelf, etc.">
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <div class="pull-right">
          <a href="add_product.php" class="btn btn-primary">Add Item</a>
        </div>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table id="productsTable" class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th>Image</th>
                <th>Name</th>
                <th class="text-center" style="width: 12%;">Category</th>
                <th class="text-center" style="width: 10%;">Shelf</th>
                <th class="text-center" style="width: 10%;">Stock</th>
                <th class="text-center" style="width: 10%;">Attache</th>
                <th class="text-center">Note</th>
                <th class="text-center">QR Code</th>
                <th class="text-center" style="width: 100px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 1;
              foreach ($products as $product):
                ?>
                <tr>
                  <td class="text-center"><?php echo $i++; ?></td>
                  <td>
                    <?php $imgSrc = empty($product['image']) ? base_url('uploads/products/no_image.jpg') : base_url('uploads/products/' . $product['image']); ?>
                    <img
                      class="img-avatar img-circle item-preview-thumb"
                      src="<?php echo $imgSrc; ?>"
                      alt="Product image"
                      style="cursor:pointer;"
                      onerror="this.onerror=null;this.src='<?php echo base_url('uploads/products/no_image.jpg'); ?>';"
                      data-name="<?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?>"
                      onclick="openItemPreview(this)">
                  </td>
                  <td><?php echo remove_junk($product['name']); ?></td>
                  <td class="text-center"><?php echo remove_junk($product['category_name'] ?: $product['catalog_category']); ?></td>
                  <td class="text-center"><?php echo remove_junk($product['shelf'] ?: '—'); ?></td>
                  <td class="text-center"><?php echo remove_junk($product['quantity']); ?></td>
                  <td class="text-center"><?php echo read_date($product['date']); ?></td>
                  <td><?php echo isset($product['note']) ? remove_junk($product['note']) : ''; ?></td>
                  <td class="text-center">
                    <?php if (!empty($product['qr_code'])): ?>
                      <img src="<?php echo base_url($product['qr_code']); ?>" alt="QR Code" style="width: 100px;">
                      <a href="<?php echo base_url($product['qr_code']); ?>" class="btn btn-success btn-xs" download>Download</a>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <div class="btn-group">
                      <a href="edit_product.php?id=<?php echo (int) $product['id']; ?>" class="btn btn-info btn-xs"
                        title="Edit" data-toggle="tooltip">
                        <i class="fa-solid fa-pencil"></i>
                      </a>
                      <a href="delete_product.php?id=<?php echo (int) $product['id']; ?>" class="btn btn-danger btn-xs"
                        title="Delete" data-toggle="tooltip">
                        <i class="fa-solid fa-trash-can"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="itemPreviewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="itemPreviewTitle">Item preview</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img id="itemPreviewImage" src="<?php echo base_url('uploads/products/no_image.jpg'); ?>" alt="Preview" style="max-width:100%;max-height:70vh;object-fit:contain;">
      </div>
    </div>
  </div>
</div>

<script>
  function openItemPreview(el) {
    var img = document.getElementById('itemPreviewImage');
    var title = document.getElementById('itemPreviewTitle');
    img.src = el.src;
    title.textContent = el.dataset.name || 'Item preview';
    new bootstrap.Modal(document.getElementById('itemPreviewModal')).show();
  }
</script>

<?php include_once(__DIR__ . '/../views/footer.php'); ?>
