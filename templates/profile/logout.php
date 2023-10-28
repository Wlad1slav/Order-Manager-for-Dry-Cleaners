<?php
require_once 'User.php';
User::checkLogin();

global $router;
unset($_SESSION['user']['id']);
$router->redirect('login');