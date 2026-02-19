<?php
require_once __DIR__ . '/../../../core/bootstrap.php';

try {
    $product = ProductService::updateFromRequest($_POST, $_FILES);
    $_SESSION['product_updated'] = 1;
    Core::redir('index.php?view=product-edit&product_id=' . $product->id);
} catch (RuntimeException $e) {
    die($e->getMessage());
}
?>
