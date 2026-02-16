﻿<?php
  ob_start();
  require_once(__DIR__ . '/../includes/load.php');
  if ($session->isUserLoggedIn(true)) { 
      redirect('admin.php', false);
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>html, body { background-color: #1b212d !important; }</style>
    <meta name="theme-color" content="#1b212d">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
    <link rel="stylesheet" href="<?php echo base_url('libs/css/main.css'); ?>" />
    <style>
        /* Asegurar que el body ocupe toda la pantalla */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center ;
            background: #1b212d;
        }
        /* Centrando el login */
        .login-page {
            width: 350px;
            padding: 20px;
            background-color: #242a38;
            border: 1px solid #2f384a;
            color: #ffffff;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
            border-radius: 5px;
            text-align: center;
        }
        /* Mejorando la apariencia del bot??n */
        .btn-info {
            width: 100%;
        }
    </style>
</head>
<body>

<div class="login-page">
    <div class="text-center">
       <h1>Welcome</h1>
       <p>Login</p>
    </div>
    <?php echo display_msg($msg); ?>
    <form method="post" action="<?php echo base_url('api/auth.php'); ?>" class="clearfix">
        <div class="form-group">
            <label for="username" class="control-label">User</label>
            <input type="text" class="form-control" name="username" placeholder="User">
        </div>
        <div class="form-group">
            <label for="password" class="control-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info">Access</button>
        </div>
    </form>
</div>

</body>
</html>
