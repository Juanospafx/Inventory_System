<ul>
  <li>
    <a href="<?php echo base_url('pages/admin.php'); ?>">
      <i class="glyphicon glyphicon-home"></i>
      <span>Control panel</span>
    </a>
  </li>
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-user"></i>
      <span>Accesses</span>
    </a>
    <ul class="nav submenu">
      <li><a href="<?php echo base_url('pages/group.php'); ?>">Manage groups</a> </li>
      <li><a href="<?php echo base_url('pages/users.php'); ?>">Manage users</a> </li>
    </ul>
  </li>
  <li>
    <a href="<?php echo base_url('pages/shelf.php'); ?>">
      <i class="glyphicon glyphicon-indent-left"></i>
      <span>Shelves</span>
    </a>
  </li>

  <li>
    <a href="<?php echo base_url('pages/projects.php'); ?>">
      <i class="glyphicon glyphicon-indent-left"></i>
      <span>Projects</span>
    </a>
  </li>

  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-th-large"></i>
      <span>Items</span>
    </a>
    <ul class="nav submenu">
      <li><a href="<?php echo base_url('pages/product.php'); ?>">Manage Items</a> </li>
      <li><a href="<?php echo base_url('pages/add_product.php'); ?>">Add Items</a> </li>
    </ul>
  </li>
  <li>
    <a href="<?php echo base_url('pages/media.php'); ?>">
      <i class="glyphicon glyphicon-picture"></i>
      <span>Media</span>
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
      <span>Repo. Input/Output</span>
    </a>
    <ul class="nav submenu">
      <li><a href="<?php echo base_url('pages/movements_report.php'); ?>">Input/Output by dates </a></li>
      <li><a href="<?php echo base_url('pages/monthly_movements.php'); ?>">Input/Output by month</a></li>
      <li><a href="<?php echo base_url('pages/daily_movements.php'); ?>">Daily Input/Output </a> </li>
    </ul>
  </li>
</ul>

