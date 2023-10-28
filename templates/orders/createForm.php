<?php
global $DIR;
global $router;

require_once 'Order.php';
require_once 'Product.php';
require_once 'Goods.php';
require_once 'User.php';

$user = User::checkLogin();

const REDIRECT = 'ordersTable';
const ERROR_TITLE = '<b>Помилка при створенні замовлення</b><br>';
const PRODUCTS_NUM = 5;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $productions = [];

    for ($i = 1; $i <= PRODUCTS_NUM; $i++) {

        $goodName = $_POST["good-name-$i"];
        if ($goodName == null) break; // Перевіряє, чи пусте поле продукту. Якщо пусте, то це значить що це кінечний виріб.

        $good = Goods::get(null,$goodName);

        $productions[] = new Product(
            $_POST["amount-$i"],
            $_POST["notes-textarea-$i"],
            [],
            $good,
        );

    }

    $customer = Customer::get(null, $_POST["customer-name"]);

    $order = new Order($customer, $user, $productions);
    $order->save();

}