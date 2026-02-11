<ul>
  <li>
    <a href="<?php echo base_url('pages/home.php'); ?>">
      <i class="glyphicon glyphicon-home"></i>
      <span>Control panel</span>
    </a>
  </li>
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-th-list"></i>
      <span>Input/Output</span>
    </a>
    <ul class="nav submenu">
      <li><a href="<?php echo base_url('pages/movements.php'); ?>">Manage Input/Output</a> </li>
      <li><a href="<?php echo base_url('pages/add_movement.php'); ?>">Add Input/Output</a> </li>
    </ul>
  </li>
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-signal"></i>
      <span>Report of Input/Output</span>
    </a>
    <ul class="nav submenu">
      <li><a href="<?php echo base_url('pages/movements_report.php'); ?>">Input/Output by dates </a></li>
      <li><a href="<?php echo base_url('pages/monthly_movements.php'); ?>">Input/Output by month</a></li>
      <li><a href="<?php echo base_url('pages/daily_movements.php'); ?>">Daily Input/Output </a> </li>
    </ul>
  </li>
</ul>
