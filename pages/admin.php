<?php
$page_title = 'Admin home page';
require_once(__DIR__ . '/../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);
?>

<?php
$c_shelf = count_by_id('shelves');
$c_product = count_by_id('products');
$c_movement = count_by_id('movements');
$c_user = count_by_id('users');
$products_moved = find_highest_moving_product('10');
$recent_products = find_recent_product_added('5');
$recent_movements = find_recent_movements('5'); // Cambiado de recent_sales a recent_movements
?>

<?php include_once(__DIR__ . '/../views/header.php'); ?>


<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<!-- Tarjetas de estadísticas (Stats Cards) - Actualizadas a la estructura de Bootstrap 5 y clases personalizadas .card-box -->
<div class="row">
  <div class="col-lg-3 col-md-6 mb-4">
    <div class="card card-box">
      <div class="card-body">
        <div class="card-icon bg-green">
          <i class="fa-solid fa-users"></i>
        </div>
        <div class="card-value flex-grow-1 text-end p-3">
          <h2 class="mb-1"> <?php echo $c_user['total']; ?> </h2>
          <p class="text-muted mb-0">Users</p>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 mb-4">
    <div class="card card-box">
      <div class="card-body">
        <div class="card-icon bg-red">
          <i class="fa-solid fa-cubes"></i>
        </div>
        <div class="card-value flex-grow-1 text-end p-3">
          <h2 class="mb-1"> <?php echo $c_shelf['total']; ?> </h2>
          <p class="text-muted mb-0">Shelves</p>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 mb-4">
    <div class="card card-box">
      <div class="card-body">
        <div class="card-icon bg-blue">
          <i class="fa-solid fa-box-open"></i>
        </div>
        <div class="card-value flex-grow-1 text-end p-3">
          <h2 class="mb-1"> <?php echo $c_product['total']; ?> </h2>
          <p class="text-muted mb-0">Items</p>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 mb-4">
    <div class="card card-box">
      <div class="card-body">
        <div class="card-icon bg-yellow">
          <i class="fa-solid fa-dolly"></i>
        </div>
        <div class="card-value flex-grow-1 text-end p-3">
          <h2 class="mb-1"> <?php echo $c_movement['total']; ?></h2>
          <p class="text-muted mb-0">Inputs/outputs</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12 mb-4">
    <div class="card">
      <div class="card-header">
        <strong>
          <i class="fa-solid fa-map"></i>
          <span>Warehouse Map - Touch the shelf to add an item</span>
        </strong>
      </div>
      <div class="card-body" style="position: relative; overflow-x: auto;">
        
        <?php include_once(__DIR__ . '/../views/map_dynamic_view.php'); ?>

      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Item más usado -->
  <div class="col-lg-6 mb-4">
    <div class="card">
      <div class="card-header">
        <strong>
          <i class="fa-solid fa-star"></i>
          <span> Most used Items</span>
        </strong>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-sm">
            <thead>
              <tr>
                <th>Title</th>
                <th>Total used</th>
                <th class="text-center">Total Qty</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products_moved as $product_moved): ?>
                <tr>
                  <td><?php echo remove_junk(first_character($product_moved['name'])); ?></td>
                  <td class="text-center"><?php echo (int) $product_moved['totalSold']; ?></td>
                  <td class="text-center"><?php echo (int) $product_moved['totalQty']; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Última entrada/salida -->
  <div class="col-lg-6 mb-4">
    <div class="card">
      <div class="card-header">
        <strong>
          <i class="fa-solid fa-clock-rotate-left"></i>
          <span>Last Inputs/outputs</span>
        </strong>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-sm">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th>Item</th>
                <th class="text-center">Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($recent_movements as $movement): ?>
                <tr>
                  <td class="text-center"><?php echo count_id(); ?></td>
                  <td><?php echo remove_junk(first_character($movement['product_name'])); ?></td>
                  <td class="text-center"><?php echo remove_junk(ucfirst($movement['date'])); ?></td>
                  <td class="text-center"><?php echo remove_junk($movement['status']); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Items recientemente añadidos -->
  <div class="col-lg-12 mb-4">
    <div class="card">
      <div class="card-header">
        <strong>
          <i class="fa-solid fa-plus"></i>
          <span>Items recently added</span>
        </strong>
      </div>
      <div class="card-body">
        <div class="list-group" style="max-height: 300px; overflow-y: auto;">
          <?php foreach ($recent_products as $recent_product): ?>
            <a class="list-group-item list-group-item-action" href="edit_product.php?id=<?php echo (int) $recent_product['id']; ?>">
              <div class="d-flex w-100 justify-content-between">
                <?php if (empty($recent_product['image'])): ?>
                  <img class="img-avatar rounded-circle" src="<?php echo base_url('uploads/products/no_image.jpg'); ?>" alt="No image">
                <?php else: ?>
                  <img class="img-avatar rounded-circle" src="<?php echo base_url('uploads/products/' . $recent_product['image']); ?>"
                    alt="" />
                <?php endif; ?>
                <div class="flex-grow-1 ms-3">
                  <h5 class="mb-1"><?php echo remove_junk(first_character($recent_product['name'])); ?></h5>
                  <small class="text-muted"><?php echo remove_junk(first_character($recent_product['shelf'])); ?></small>
                </div>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>

  <?php include_once(__DIR__ . '/../views/footer.php'); ?>
