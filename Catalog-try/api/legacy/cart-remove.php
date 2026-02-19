<?php
require_once __DIR__ . '/../../core/bootstrap.php';

if (!isset($_GET['id'])) {
    die('Error: No se proporciono un ID de producto.');
}

$productId = (int)$_GET['id'];
CartService::removeItem($productId);

header('Location: index.php?view=cart');
exit;
?>
