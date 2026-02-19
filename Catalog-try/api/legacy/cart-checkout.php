<?php
require_once __DIR__ . '/../../core/bootstrap.php';

if (!Session::issetUID()) {
    header('Location: login.php');
    exit;
}

CartService::clear();

header('Location: index.php?view=cart');
exit;
?>
