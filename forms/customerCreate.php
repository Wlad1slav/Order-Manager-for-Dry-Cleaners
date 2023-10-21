<?php
//session_start();
global $router;

require_once 'Customer.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $discount = $_POST["discount"];
    $advertisingCompany = $_POST["advertisingCompany"];

    try {
        $customer = new Customer($name, $phone, $discount, $advertisingCompany);
        $customer->save();
    } catch (Exception $e) {
        $_SESSION['error'] = '<b>Помилка при створенні клієнта</b><br>' . $e->getMessage();
    }
}

$router->redirect('customersTable');
