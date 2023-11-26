<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

global $DIR;
$DIR = __DIR__;

// Перевірка, чи існує база даних
require_once 'Repository.php';
$dbconfig = json_decode(file_get_contents(Repository::DB_CONFIG_PATH), true) ?? [];
if (!Repository::checkDB($dbconfig['dbname']))
    Repository::createDB($dbconfig['dbname']);
$dbconfig = null;

// Перевірка, чи існує суперкористувач. Якщо ні - він створюється
require_once 'User.php';
require_once 'Rights.php';
if (!User::isExist(1)) {
    $user = new User('root', 'root', Rights::get(1));
    $user->save();
}


// Завантаження маршрутизатору
require_once 'Router.php';
global $router;
$router = new Router();
$router->load();
$router->match();

date_default_timezone_set('Europe/Kiev');