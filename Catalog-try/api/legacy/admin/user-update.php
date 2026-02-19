<?php
require_once __DIR__ . '/../../../core/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Core::redir('index.php?view=users');
    exit;
}

$user = UserData::getById($_POST['user_id']);
if (!$user) {
    Core::redir('index.php?view=users');
    exit;
}

$user->name = htmlspecialchars($_POST['name']);
$user->lastname = htmlspecialchars($_POST['lastname']);
$user->username = htmlspecialchars($_POST['username']);
$user->email = htmlspecialchars($_POST['email']);
$user->is_active = isset($_POST['is_active']) ? 1 : 0;
$user->update();

if (!empty($_POST['password'])) {
    $user->password = sha1(md5($_POST['password']));
    $user->update_passwd();
}

if (isset($_POST['roles'])) {
    UserData::removeRoles($user->id);
    foreach ($_POST['roles'] as $role_id) {
        UserData::assignRole($user->id, $role_id);
    }
}

Core::redir('index.php?view=users');
?>
