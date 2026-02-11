<?php
$page_title = 'Items list';
require_once(__DIR__ . '/../includes/load.php');
page_require_level(2);

// Cargamos todos los productos sin filtro (el filtrado se har?? en el cliente)
$products = join_product_table();
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
                    <?php if (empty($product['image'])): ?>
                      <img class="img-avatar img-circle" src="<?php echo base_url('uploads/products/no_image.jpg'); ?>" alt="Sin imagen">
                    <?php else: ?>
                      <img class="img-avatar img-circle" src="<?php echo base_url('uploads/products/' . $product['image']); ?>"
                        alt="Imagen del producto">
                    <?php endif; ?>
                  </td>
                  <td><?php echo remove_junk($product['name']); ?></td>
                  <td class="text-center"><?php echo remove_junk($product['shelf']); ?></td>
                  <td class="text-center"><?php echo remove_junk($product['quantity']); ?></td>
                  <td class="text-center"><?php echo read_date($product['date']); ?></td>
                  <td><?php echo isset($product['note']) ? remove_junk($product['note']) : ''; ?></td>
                  <td class="text-center">
                    <?php if (!empty($product['qr_code'])): ?>
                      <img src="<?php echo $product['qr_code']; ?>" alt="QR Code" style="width: 100px;">
                      <a href="<?php echo $product['qr_code']; ?>" class="btn btn-success btn-xs" download>Download</a>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <div class="btn-group">
                      <a href="edit_product.php?id=<?php echo (int) $product['id']; ?>" class="btn btn-info btn-xs"
                        title="Editar" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-edit"></span>
                      </a>
                      <a href="delete_product.php?id=<?php echo (int) $product['id']; ?>" class="btn btn-danger btn-xs"
                        title="Eliminar" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-trash"></span>
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

<?php include_once(__DIR__ . '/../views/footer.php'); ?>
