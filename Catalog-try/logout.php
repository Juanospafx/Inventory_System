<?php
require_once __DIR__ . '/core/bootstrap.php';

// Guardar el carrito antes de salir
if (isset($_SESSION['cart'])) {
    setcookie('cart', json_encode($_SESSION['cart']), time() + (86400 * 30), '/');
}

AuthService::logout();
unset($_SESSION['user_id']);
unset($_SESSION['user_name']);

header('Location: login.php');
exit;
?>
