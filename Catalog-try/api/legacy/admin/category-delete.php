<?php
require_once __DIR__ . '/../../../core/bootstrap.php';

if (!isset($_GET['category_id'])) {
    die('Category ID missing.');
}

CategoryService::deleteById((int)$_GET['category_id']);
Core::redir('index.php?view=categories');
?>
