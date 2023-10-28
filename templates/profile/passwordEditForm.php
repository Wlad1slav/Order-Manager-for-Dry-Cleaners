<?php
require_once 'Router.php';
require_once 'User.php';

User::checkLogin();

global $router;

$user = User::get($_SESSION['user']['id']);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $user->setPassword($_POST['password']);
        $user->update();
    } catch (Exception $e) {
        $_SESSION['error'] = '<b>Помилка при зміні паролю</b><br>' . $e->getMessage();
    }
}

$router->redirect('profile');
