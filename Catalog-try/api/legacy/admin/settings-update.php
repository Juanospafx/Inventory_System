<?php
require_once __DIR__ . '/../../../core/bootstrap.php';

if (!Session::issetUID()) {
    Core::redir('./');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
    foreach ($_POST as $key => $value) {
        $key = trim($key);
        $value = trim($value);
        if ($key !== '') {
            ConfigurationData::updateValFromName($key, $value);
        }
    }
}

Core::redir('index.php?view=settings');
exit;
?>
