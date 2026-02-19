<?php
require_once __DIR__ . '/../../core/bootstrap.php';

CartService::ensureCart();

$productIds = [];

if (isset($_GET['items']) && is_array($_GET['items'])) {
    foreach ($_GET['items'] as $item) {
        if (!isset($item['selected']) || (int)$item['selected'] !== 1) {
            continue;
        }
        if (!isset($item['post_id'])) {
            continue;
        }
        $productIds[] = (int)$item['post_id'];
    }
} elseif (isset($_GET['selected_items']) && is_array($_GET['selected_items'])) {
    foreach ($_GET['selected_items'] as $pid) {
        $productIds[] = (int)$pid;
    }
} elseif (isset($_GET['product_id']) && $_GET['product_id'] !== '') {
    $productIds[] = (int)$_GET['product_id'];
}

if (empty($productIds)) {
    header('Location: index.php?view=cart');
    exit;
}

$globalQuantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;
$globalUnit = isset($_GET['unit']) ? (string)$_GET['unit'] : 'ea';

foreach ($productIds as $pid) {
    CartService::addItem($pid, $globalQuantity, $globalUnit);
}

if (isset($_GET['redirect_product_id'])) {
    $redirectId = (int)$_GET['redirect_product_id'];
    header('Location: index.php?view=product&product_id=' . $redirectId);
    exit;
}

header('Location: index.php?view=cart');
exit;
?>
