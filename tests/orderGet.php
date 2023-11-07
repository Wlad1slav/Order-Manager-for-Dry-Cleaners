<?php

require_once 'Order.php';
require_once 'Customer.php';
require_once 'User.php';
require_once 'Product.php';
require_once 'Goods.php';

$order = Order::get(2);
print_r($order);
//$order->setIsPaid(true);
//$order->update();