<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

global $DIR;
$DIR = __DIR__;

require_once 'Router.php';

$router = new Router();
require_once 'settings/routes.php';

//print_r($router->routes);