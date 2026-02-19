<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!Session::issetUID()) {
    header("Location: ../login.php");
    exit;
}

$user_id = Session::getUID();
$roles = Session::getRoles();
$is_admin = Session::hasRole("Administrador");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Brigtronix | Dashboard</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link href="plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="plugins/dist/css/AdminLTE.min.css" rel="stylesheet">
    <link href="plugins/dist/css/skins/skin-blue-light.min.css" rel="stylesheet">

    <script src="plugins/jquery/jquery-2.1.4.min.js"></script>
</head>

<body class="skin-blue-light sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <a href="./" class="logo">
                <span class="logo-mini"><b>B</b>T</span>
                <span class="logo-lg"><b>Brig</b>Tronix</span>
            </a>

            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span><?php echo htmlspecialchars(UserData::getById($user_id)->name); ?></span>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <a href="../logout.php" class="btn btn-default btn-flat">Salir</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar">
            <section class="sidebar">
                <ul class="sidebar-menu">
                    <li class="header">ADMINISTRACION</li>
                    <li><a href="./"><i class='fa fa-dashboard'></i> <span>Dashboard</span></a></li>

                    <li class="treeview">
                        <a href="#"><i class="fa fa-folder"></i><span>Catalogo</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
                            <li><a href="./?view=products"><i class="fa fa-circle-o"></i> Productos</a></li>
                            <li><a href="./?view=categories"><i class="fa fa-circle-o"></i> Categorias</a></li>
                        </ul>
                    </li>
                    <li><a href="./?view=slider"><i class='fa fa-th-large'></i> <span>Slider</span></a></li>

                    <?php if ($is_admin): ?>
                        <li><a href="./?view=users"><i class='fa fa-user'></i> <span>Usuarios</span></a></li>
                    <?php endif; ?>
                </ul>
            </section>
        </aside>

        <div class="content-wrapper">
            <section class="content">
                <?php View::load("dashboard"); ?>
            </section>
        </div>

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> v1.2
            </div>
            <strong>Copyright &copy; 2025 <a href="https://brightronix.com/wp/" target="_blank">Brigtronix</a></strong>
        </footer>

    </div>

    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/dist/js/app.min.js"></script>
</body>
</html>
