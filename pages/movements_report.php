﻿<?php
$page_title = 'Inputs/outputs Report';
require_once(__DIR__ . '/../includes/load.php');
// Verificar que el usuario tenga permiso para ver esta p??gina
page_require_level(3);
?>
<?php include_once(__DIR__ . '/../views/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Select date range</h3>
      </div>
      <div class="panel-body">
        <form class="clearfix" method="post" action="movement_report_process.php">
          <div class="mb-3">
            <label class="form-label"> Date Range</label>
            <div class="input-group">
              <input type="text" class="datepicker form-control" name="start-date" placeholder="Desde">
              <span class="input-group-text">
                <i class="fa-solid fa-arrow-right"></i>
              </span>
              <input type="text" class="datepicker form-control" name="end-date" placeholder="Hasta">
            </div>
          </div>
          <div class="mb-3">
            <button type="submit" name="submit" class="btn btn-primary">Generate Report</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include_once(__DIR__ . '/../views/footer.php'); ?>
