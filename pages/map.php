<?php
$page_title = 'Warehouse Map';
require_once(__DIR__ . '/../includes/load.php');
page_require_level(2);
?>
<?php include_once(__DIR__ . '/../views/header.php'); ?>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <strong>
          <i class="fa-solid fa-map"></i>
          <span>Warehouse Map - Touch the shelf to add an item</span>
        </strong>
      </div>
      <div class="card-body" style="position: relative; overflow-x: auto;">
        
        <?php include_once(__DIR__ . '/../views/map_view.php'); ?>

      </div>
    </div>
  </div>
</div>

<?php include_once(__DIR__ . '/../views/footer.php'); ?>