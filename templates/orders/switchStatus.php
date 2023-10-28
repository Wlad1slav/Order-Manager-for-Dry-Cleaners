<?php

require_once 'User.php';
User::checkLogin();

require_once 'Order.php';

$newStatus = $_GET['newStatus'];
$orderID = $_GET['orderID'];
$column = $_GET['column'];

//echo $newStatus . '<br>';
//echo $column;

if ($newStatus === 'true')
    $newStatus = true;
elseif ($newStatus === 'false')
    $newStatus = false;
else die('...');

$order = Order::get($orderID);

if ($column == 'is_paid')
    $order->setIsPaid($newStatus);
elseif ($column == 'is_completed')
    $order->setIsCompleted($newStatus);

echo 'isPaid = ' . $order->isPaid();
echo 'isCompleted = ' . $order->isCompleted();
$order->update();


