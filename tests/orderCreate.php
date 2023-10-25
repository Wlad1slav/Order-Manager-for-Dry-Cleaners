<?php
require_once 'Order.php';
require_once 'Customer.php';
require_once 'User.php';
require_once 'Product.php';
require_once 'Goods.php';

$order = new Order(
    Customer::get(3437),
    User::get(2),
    [new Product(
        2,
        '',
        [],
        Goods::get(2))
    ]
);

$order->save();