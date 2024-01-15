<?php
global $router;

require_once 'Router.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $right = $_POST["rights"];
    try {
        $user = new User($username, $password, $right);
        $user->save();
    } catch (Exception $e) {
        $_SESSION['error'] = '<b>Помилка при створенні користувача</b><br>' . $e->getMessage();
    }
}

$router->redirect('usersTable');
