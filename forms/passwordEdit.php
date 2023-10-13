<?php
session_start();

require_once '../Router.php';
require_once '../templates/profile.php';

/**
 * @var $user
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $user->setPassword($_POST['password']);
        $user->update();
    } catch (Exception $e) {
        $_SESSION['error'] = '<b>Помилка при зміні паролю</b><br>' . $e->getMessage();
    }
}

Router::redirect('/profile');
