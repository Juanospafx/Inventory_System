<?php
require_once __DIR__ . '/../../../core/bootstrap.php';

CategoryService::createFromRequest($_POST);
Core::redir('index.php?view=categories');
?>
