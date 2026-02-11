<?php $user = current_user(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?php if (!empty($page_title))
    echo remove_junk($page_title);
  elseif (!empty($user))
    echo ucfirst($user['name']);
  else
    echo "Brigtronix- INVI"; ?>
  </title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
  <link rel="stylesheet" href="<?php echo base_url('libs/css/main.css'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <?php if ($session->isUserLoggedIn()): ?>
    <header id="header">
      <div class="logo pull-left"> Brigtronix- Inventory </div>
      <div class="header-content">
        <div class="sidebar-toggle">
          <a href="#" class="sidebar-toggle-btn"><i class="fa fa-bars"></i></a>
        </div>
        <div class="header-date pull-left">
          <strong><span id="time"></span></strong>
        </div>
        <div class="pull-right clearfix">
          <ul class="info-menu list-inline list-unstyled">
            <li class="profile">
              <a href="#" data-toggle="dropdown" class="toggle" aria-expanded="false">
                <img src="<?php echo base_url('uploads/users/' . $user['image']); ?>" alt="user-image" class="img-circle img-inline">
                <span><?php echo remove_junk(ucfirst($user['name'])); ?> <i class="caret"></i></span>
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a href="<?php echo base_url('pages/profile.php?id=' . (int) $user['id']); ?>">
                    <i class="glyphicon glyphicon-user"></i>
                    Profile
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url('pages/edit_account.php'); ?>" title="edit account">
                    <i class="glyphicon glyphicon-cog"></i>
                    Configuration
                  </a>
                </li>
                <li class="last">
                  <a href="<?php echo base_url('api/logout.php'); ?>">
                    <i class="glyphicon glyphicon-off"></i>
                    Logout
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </header>
    <div class="sidebar">
      <?php if ($user['user_level'] === '1'): ?>
        <!-- admin menu -->
        <?php include_once(__DIR__ . '/admin_menu.php'); ?>

      <?php elseif ($user['user_level'] === '2'): ?>
        <!-- Special user -->
        <?php include_once(__DIR__ . '/special_menu.php'); ?>

      <?php elseif ($user['user_level'] === '3'): ?>
        <!-- User menu -->
        <?php include_once(__DIR__ . '/user_menu.php'); ?>

      <?php endif; ?>

    </div>
  <?php endif; ?>

  <div class="page">
    <div class="container-fluid">
