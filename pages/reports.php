<?php
$page_title = 'Reports';
require_once(__DIR__ . '/../includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);

// Daily Movements Data
$year = date('Y');
$month = date('m');
$daily_movements = daily_movements($year, $month);

// Monthly Movements Data
$monthly_movements = monthly_movements($year);
?>
<?php include_once(__DIR__ . '/../views/header.php'); ?>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<!-- Date Range Report Section -->
<div class="row">
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <i class="fa-solid fa-calendar-days"></i>
          <span>Input/Output Report by Dates</span>
        </strong>
      </div>
      <div class="panel-body">
        <form class="clearfix" method="post" action="movement_report_process.php">
          <div class="mb-3">
            <label class="form-label">Date Range</label>
            <div class="input-group">
              <input type="date" class="form-control" name="start-date" placeholder="From">
              <span class="input-group-text">
                <i class="fa-solid fa-arrow-right"></i>
              </span>
              <input type="date" class="form-control" name="end-date" placeholder="To">
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

<!-- Daily Movements Section -->
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <i class="fa-solid fa-calendar-day"></i>
          <span>Daily Input/Output</span>
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
              <?php $i = 1; foreach ($daily_movements as $movement): ?>
                <tr>
                  <td class="text-center"><?php echo $i++; ?></td>
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

<!-- Monthly Movements Section -->
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <i class="fa-solid fa-calendar"></i>
          <span>Monthly Input/Output</span>
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
              <?php $j = 1; foreach ($monthly_movements as $movement): ?>
                <tr>
                  <td class="text-center"><?php echo $j++; ?></td>
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

<?php include_once(__DIR__ . '/../views/footer.php'); ?>