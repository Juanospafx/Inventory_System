<?php
require_once __DIR__ . '/../../../core/bootstrap.php';

ProductService::createFromRequest($_POST, $_FILES);
Core::redir('index.php?view=products');
?>
