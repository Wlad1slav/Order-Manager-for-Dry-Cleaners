<?php
/**     @var $router
        ФАЙЛ МАРШРУТИЗАЦІЇ СТОРІНОК
*/

// КОРИСТУВАЧІ
$router->get('users', 'templates/users.php');
$router->post('users', 'forms/users.php');
$router->get('users/delete', 'templates/userDelete.php');

// КЛІЄНТИ
$router->get('customers', 'templates/customers.php');
$router->get('customers/delete', 'templates/customerDelete.php');

// СЕРВІСИ
$router->get('products', 'templates/products.php');

// ІНШЕ
$router->get('error', 'templates/error-page.php');

$router->match();