<?php
require_once __DIR__ . '/../../../core/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Core::redir('index.php?view=user-new');
    exit;
}

if (!isset($_POST['roles']) || empty($_POST['roles'])) {
    Core::redir('index.php?view=user-new');
    exit;
}

$user = new UserData();
$user->name = trim((string)$_POST['name']);
$user->lastname = trim((string)$_POST['lastname']);
$user->username = trim((string)$_POST['username']);
$user->email = trim((string)$_POST['email']);
$user->password = sha1(md5($_POST['password']));
$user_id = $user->add();

foreach ($_POST['roles'] as $role_id) {
    UserData::assignRole($user_id, $role_id);
}

Core::redir('index.php?view=users');
?>
