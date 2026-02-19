<?php
require_once __DIR__ . '/../../../core/bootstrap.php';

try {
    CategoryService::updateFromRequest($_POST);
    Core::redir('index.php?view=categories');
} catch (RuntimeException $e) {
    die($e->getMessage());
}
?>
