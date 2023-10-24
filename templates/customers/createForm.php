<?php
global $router;

require_once 'Customer.php';

CONST REDIRECT = 'customersTable';
CONST ERROR_TITLE = '<b>Помилка при створенні клієнта</b><br>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $discount = $_POST["discount"];
    $advertisingCompany = $_POST["advertisingCompany"];

    try {
        $customer = new Customer($name, $phone, $discount, $advertisingCompany);
        $customer->save();
    } catch (Exception $e) {
        $_SESSION['error'] = ERROR_TITLE . $e->getMessage();
    }
}

$router->redirect(REDIRECT);
