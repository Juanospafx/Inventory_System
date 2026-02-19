<?php
require_once __DIR__ . '/../../../core/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Core::redir('login.php');
    exit;
}

$username = $_POST['username'] ?? $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$result = AuthService::login($username, $password);
if ($result['ok']) {
    Core::redir('admin/');
    exit;
}

Core::redir('login.php?error=' . urlencode($result['error'] ?? 'Error de autenticacion.'));
?>
