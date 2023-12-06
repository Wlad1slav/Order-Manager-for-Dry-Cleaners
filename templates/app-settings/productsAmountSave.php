<?php // Збереження кількості виробів в одном замовленні
require_once "Order.php";
global $router;

$orderSettings = Order::getJsonConfig();
$orderSettings["Number of products"] = $_POST["products-amount"];

Order::setJsonConfig($orderSettings);

$router->redirect('settingsPage');