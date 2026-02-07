<?php
$page_title = 'Month report';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);
?>

<?php
$year = date('Y');
$movements = monthly_movements($year); // Nueva función para movimientos mensuales
?>

<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Monthly inputs/outpus record</span>
        </strong>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th>Description</th>
                <th class="text-center" style="width: 15%;">Quantity</th>
                <th class="text-center" style="width: 15%;">Status</th>
                <th class="text-center" style="width: 15%;">Date</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($movements as $movement): ?>
                <tr>
                  <td class="text-center"><?php echo count_id(); ?></td>
                  <td><?php echo remove_junk($movement['product_name']); ?></td>
                  <td class="text-center"><?php echo (int) $movement['quantity']; ?></td>
                  <td class="text-center"><?php echo remove_junk($movement['status']); ?></td>
                  <td class="text-center"><?php echo date("d/m/Y", strtotime($movement['date'])); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>