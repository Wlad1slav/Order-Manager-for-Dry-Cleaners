<?php
session_start();
global $router;

require_once 'User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = $_POST['login'] ?? null;
    $password = $_POST['password'] ?? null;

    User::authorization($login, $password);
}
