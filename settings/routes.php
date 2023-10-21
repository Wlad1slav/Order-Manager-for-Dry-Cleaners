<?php
/**     @var $router
        ФАЙЛ МАРШРУТИЗАЦІЇ СТОРІНОК
*/

// КОРИСТУВАЧІ
$router->get('login', 'templates/login.php', 'login');                                  // Сторінка авторизації
$router->post('login', 'forms/login.php', 'auth');                                      // Форма авторизації
$router->get('logout', 'templates/logout.php', 'logout');                               // Виход з акаунту
$router->get('profile', 'templates/profile.php', 'profile');                            // Сторінка профілю
$router->get('users', 'templates/users.php', 'usersTable');                             // Перелік усіх користувачів
$router->post('users', 'forms/userCreate.php', 'userCreate');                           // Форма створення нового користувача
$router->get('users/delete', 'templates/userDelete.php', 'userDelete');                 // Вилучення користувача

// ЗАМОВЛЕННЯ
$router->get('orders', 'templates/orders.php', 'ordersTable');                          // Сторінка з усіма замовленнями
$router->get('switchStatus', 'forms/switchStatus.php', 'switchOrderStatus');            // Сторінка зміни статусу замовлення
$router->get('orders/new', 'templates/createOrder.php', 'orderCreate');                 // Сторінка створення замовлення

// КЛІЄНТИ
$router->get('customers', 'templates/customers.php', 'customersTable');                 // Сторінка з усіма клієнтами
$router->post('customers', 'forms/customerCreate.php', 'customerCreate');               // Форма створення нового клієнта
$router->get('customers/delete', 'templates/customerDelete.php', 'customerDelete');     // Видалення клієнта

// СЕРВІСИ
$router->get('products', 'templates/products.php', 'productsList');                     // Сторінка з усіма сервісами

// ІНШЕ
$router->get('error', 'templates/error-page.php', 'error');                             // Сторінка помилки
//$router->get('#', '', '#');                                                                              // Заглушка

$router->match();