<?php // Збереження кількості виробів в одном замовленні
require_once "Order.php";
global $router;

$orderSettings = Order::getOrdersSettings();
$orderSettings["Number of products"] = $_POST["products-amount"];

Order::updateOrdersSettings($orderSettings);

$router->redirect('settingsPage');