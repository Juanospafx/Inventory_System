<?php
require_once __DIR__ . '/core/bootstrap.php';

if (Session::issetUID()) {
    if (Session::hasRole('Administrador')) {
        header('Location: admin/');
    } else {
        header('Location: index.php');
    }
    exit;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = AuthService::login($username, $password);
    if ($result['ok']) {
        if (Session::hasRole('Administrador')) {
            header('Location: admin/');
        } else {
            header('Location: index.php');
        }
        exit;
    }
    $error = $result['error'] ?? 'Error de autenticacion.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Brigtronix</title>
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f2f7;
            font-family: Arial, sans-serif;
        }
        .login-container {
            width: 360px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .login-container h2 {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .login-container p {
            font-size: 14px;
            color: #777;
            margin-bottom: 20px;
        }
        .login-container input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        .btn-access {
            width: 100%;
            padding: 10px;
            background: #5bc0de;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-access:hover {
            background: #31b0d5;
        }
        .alert-danger {
            font-size: 14px;
            margin-top: 10px;
            padding: 10px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Welcome</h2>
    <p>Login</p>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="login.php">
        <input type="text" name="username" placeholder="User" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn-access">Access</button>
    </form>
</div>

</body>
</html>
