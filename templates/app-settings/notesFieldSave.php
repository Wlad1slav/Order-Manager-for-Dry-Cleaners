<?php // Збереження масиву швидкого вибору нотатків
require_once "Order.php";
global $router;

$orderSettings = Order::getOrdersSettings();
$orderSettings["Quick note selection"] = explode(',', $_POST["notes-default"]);

Order::updateOrdersSettings($orderSettings);

$router->redirect('settingsPage');