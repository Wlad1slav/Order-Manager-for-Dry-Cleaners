<?php

global $router;

require_once 'Customer.php';

CONST REDIRECT = 'customersTable';
CONST ERROR_TITLE = '<b>Помилка при редагуванні клієнта</b><br>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $discount = $_POST["discount"];
    $advertisingCompany = $_POST["advertisingCompany"];

    try {
        $customer = Customer::get($id);
        $customer->setFullName($name);
        $customer->setPhoneNumber($phone);
        $customer->setDiscount($discount);
        $customer->setAdvertisingCompany($advertisingCompany);
        $customer->update();
    } catch (Exception $e) {
        $_SESSION['error'] = '<b>Помилка при редагуванні клієнта</b><br>' . $e->getMessage();
    }
}

$router->redirect(REDIRECT);
