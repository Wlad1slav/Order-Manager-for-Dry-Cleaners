<?php // Збереження масиву швидкого вибору нотатків
require_once "Order.php";
global $router;

$orderSettings = Order::getJsonConfig();
$orderSettings["Quick note selection"] = explode(',', $_POST["notes-default"]);

Order::setJsonConfig($orderSettings);

$router->redirect('settingsPage');