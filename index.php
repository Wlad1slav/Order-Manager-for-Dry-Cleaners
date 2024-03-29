<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

global $DIR;
$DIR = __DIR__;

// Перевірка, чи існує база даних
require_once 'Repository.php';
$dbconfig = Repository::getJsonConfig();
if (!Repository::checkDB($dbconfig['dbname']))
    Repository::createDB($dbconfig['dbname']);
$dbconfig = null;

// Перевірка, чи існує суперкористувач. Якщо ні - він створюється
require_once 'User.php';
require_once 'Rights.php';
if (count(User::getAll()) === 0) {
    $user = new User('root', 'root', 'root');
    $user->save();
}


// Завантаження маршрутизатору
require_once 'Router.php';
global $router;
$router = new Router();
$router->load();
$router->match();

date_default_timezone_set('Europe/Kiev');