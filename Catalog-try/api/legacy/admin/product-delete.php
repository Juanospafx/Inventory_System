<?php
require_once __DIR__ . '/../../../core/bootstrap.php';

if (!isset($_GET['product_id'])) {
    die('Product ID missing.');
}

ProductService::deleteById((int)$_GET['product_id']);
Core::redir('index.php?view=products');
?>
