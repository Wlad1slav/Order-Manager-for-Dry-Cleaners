<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
include 'Order.php';
include 'Product.php';
include 'Goods.php';
include 'User.php';
include 'Rights.php';
include 'Customer.php';
include 'Utils.php';


// ТОВАРИ
$good1 = new Goods(1, 'яйце', 17);
$good2 = new Goods(2, 'пакет молока', 35);

// ВИРОБИ
$productions = [new Product(10, 'біле', ['термін придатності'=>'14.10.23', 'тримати при температурі (г.ц.)'=>10], $good1),
    new Product(2, 'Галичина', ['термін придатності'=>'23.10.23', 'тримати при температурі (г.ц.)'=>12], $good2),
    new Product(1, 'жовте', ['термін придатності'=>'13.10.23', 'тримати при температурі (г.ц.)'=>10], $good1),];

// РІВЕНЬ ПРАВ
$root = new Rights(1, "ROOT", ['*'=>true]);

// КОРИСТУВАЧ
$vlad = new User(1, 'Vladyslav', '12345678', $root);

// КЛІЄНТ
$oleksandr = new Customer(1, "Oleksandr Oleksandroviczh Oleksandrov", "+380(00)000-000", 50.0);

// ЗАМОВЛЕННЯ
$order = new Order(1, $oleksandr, $vlad, $productions);


foreach ($order->getComponents() as $num => $component) {
    echo "<b>Виріб #{$num}:</b><br>";
    foreach ($component as $key => $value) {
        echo "- {$key}: {$value} <br>";
    }
    echo '<hr>';
}
echo 'Загальна ціна: ' . $order->getTotalPrice() . ' грн. <br>Знижка: ' . $order->getCustomer()->getDiscount() . '%';

?>

</body>
</html>