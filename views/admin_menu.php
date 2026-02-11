<!-- Menú de navegación actualizado con iconos de Font Awesome en lugar de Glyphicons -->
<ul>
  <li>
    <a href="<?php echo base_url('pages/admin.php'); ?>">
      <i class="fa-solid fa-house"></i>
      <span>Control panel</span>
    </a>
  </li>
  <li>
    <a href="#" class="submenu-toggle">
      <i class="fa-solid fa-users"></i>
      <span>Accesses</span>
    </a>
    <ul class="submenu">
      <li><a href="<?php echo base_url('pages/group.php'); ?>">Manage groups</a> </li>
      <li><a href="<?php echo base_url('pages/users.php'); ?>">Manage users</a> </li>
    </ul>
  </li>
  <li>
    <a href="<?php echo base_url('pages/shelf.php'); ?>">
      <i class="fa-solid fa-shelves"></i>
      <span>Shelves</span>
    </a>
  </li>

  <li>
    <a href="<?php echo base_url('pages/projects.php'); ?>">
      <i class="fa-solid fa-diagram-project"></i>
      <span>Projects</span>
    </a>
  </li>

  <li>
    <a href="#" class="submenu-toggle">
      <i class="fa-solid fa-box-open"></i>
      <span>Items</span>
    </a>
    <ul class="submenu">
      <li><a href="<?php echo base_url('pages/product.php'); ?>">Manage Items</a> </li>
      <li><a href="<?php echo base_url('pages/add_product.php'); ?>">Add Items</a> </li>
    </ul>
  </li>
  <li>
    <a href="<?php echo base_url('pages/media.php'); ?>">
      <i class="fa-solid fa-image"></i>
      <span>Media</span>
    </a>
  </li>
  <li>
    <a href="#" class="submenu-toggle">
      <i class="fa-solid fa-dolly"></i>
      <span>Input/Output</span>
    </a>
    <ul class="submenu">
      <li><a href="<?php echo base_url('pages/movements.php'); ?>">Manage Input/Output</a> </li>
      <li><a href="<?php echo base_url('pages/add_movement.php'); ?>">Add Input/Output</a> </li>
    </ul>
  </li>
  <li>
    <a href="#" class="submenu-toggle">
      <i class="fa-solid fa-chart-line"></i>
      <span>Repo. Input/Output</span>
    </a>
    <ul class="submenu">
      <li><a href="<?php echo base_url('pages/movements_report.php'); ?>">Input/Output by dates </a></li>
      <li><a href="<?php echo base_url('pages/monthly_movements.php'); ?>">Input/Output by month</a></li>
      <li><a href="<?php echo base_url('pages/daily_movements.php'); ?>">Daily Input/Output </a> </li>
    </ul>
  </li>
</ul>
