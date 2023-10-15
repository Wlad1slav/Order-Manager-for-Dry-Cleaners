<?php
/**     @var $router
        ФАЙЛ МАРШРУТИЗАЦІЇ СТОРІНОК
*/

// КОРИСТУВАЧІ
$router->get('login', 'templates/login.php');                       // Сторінка авторизації
$router->post('login', 'forms/login.php');                          // Форма авторизації
$router->get('logout', 'templates/logout.php');                     // Виход з акаунту
$router->get('profile', 'templates/profile.php');                   // Сторінка профілю
$router->get('users', 'templates/users.php');                       // Перелік усіх користувачів
$router->post('users', 'forms/users.php');                          // Форма створення нового користувача
$router->get('users/delete', 'templates/userDelete.php');           // Вилучення користувача

// ЗАМОВЛЕННЯ
$router->get('orders', 'templates/orders.php');                     // Сторінка з усіма замовленнями
$router->get('switchStatus', 'forms/switchStatus.php');             // Сторінка зміни статусу замовлення

// КЛІЄНТИ
$router->get('customers', 'templates/customers.php');               // Сторінка з усіма клієнтами
$router->get('customers/delete', 'templates/customerDelete.php');   // Видалення клієнта

// СЕРВІСИ
$router->get('products', 'templates/products.php');                 // Сторінка з усіма сервісами

// ІНШЕ
$router->get('error', 'templates/error-page.php');                  // Сторінка помилки

$router->match();