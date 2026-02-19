<?php
require_once __DIR__ . '/../core/bootstrap.php';

AuthService::logout();

header('Location: ../login.php');
exit;
?>
