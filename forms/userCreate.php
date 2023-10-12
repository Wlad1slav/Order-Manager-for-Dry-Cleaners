<?php
include '../templates/users.php';
require_once '../Router.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $rights = require '../settings/rights_list.php';
    $right = $rights[$_POST["rights"]-1];
    try {
        $user = new User($username, $password, $right);
        $user->save();
    } catch (Exception $e) {
        $_SESSION['error'] = '<b>Помилка при створенні користувача</b><br>' . $e->getMessage();
    }
}

Router::redirect('/users');
