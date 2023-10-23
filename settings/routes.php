<?php
/**     @var $router
        МАРШРУТИЗАЦІЯ СТОРІНОК
*/

// КОРИСТУВАЧІ
const LOGIN_APP = 'login';
$router->get(LOGIN_APP, 'templates/login.php', 'login');                                    // Сторінка авторизації
$router->post(LOGIN_APP, 'forms/login.php', 'auth');                                        // Форма авторизації
$router->get('logout', 'templates/logout.php', 'logout');                                   // Виход з акаунту
const PROFILE_APP = 'profile';
$router->get(PROFILE_APP, 'templates/profile.php', 'profile');                              // Сторінка профілю
const USERS_APP = 'users';
$router->get(USERS_APP, 'templates/users.php', 'usersTable');                               // Перелік усіх користувачів
$router->post(USERS_APP, 'forms/userCreate.php', 'userCreate');                             // Форма створення нового користувача
$router->get(USERS_APP . '/delete', 'templates/userDelete.php', 'userDelete');              // Вилучення користувача

// ЗАМОВЛЕННЯ
const ORDER_APP = 'orders';
$router->get(ORDER_APP, 'templates/orders.php', 'ordersTable');                             // Сторінка з усіма замовленнями
$router->get(ORDER_APP . '/switchStatus', 'forms/switchStatus.php', 'switchOrderStatus');                // Сторінка зміни статусу замовлення
$router->get(ORDER_APP . '/new', 'templates/createOrder.php', 'orderCreate');               // Сторінка створення замовлення

// КЛІЄНТИ
const CUSTOMERS_APP = 'customers';
$router->get(CUSTOMERS_APP, 'templates/customers.php', 'customersTable');                   // Сторінка з усіма клієнтами
$router->post(CUSTOMERS_APP, 'forms/customerCreate.php', 'customerCreate');                 // Форма створення нового клієнта
$router->get(CUSTOMERS_APP . '/delete', 'templates/customerDelete.php', 'customerDelete');  // Видалення клієнта

// СЕРВІСИ
const PRODUCTS_APP = 'products';
$router->get(PRODUCTS_APP, 'templates/products.php', 'productsList');                       // Сторінка з усіма сервісами

// НАЛАШТУВАННЯ
const SETTINGS_APP = 'app-settings';
$router->get(SETTINGS_APP, 'templates/settingsPage.php', 'settingsPage');                   // Сторінка з налаштуваннями
$router->post(SETTINGS_APP, 'forms/fieldCreate.php', 'fieldAdd');                           // Форма, що додає нове додаткове поле замовлення
$router->get('field/delete', 'templates/fieldRemove.php', 'fieldRemove');                   // Видалення додаткового поля замовлення

// ІНШЕ
$router->get('error', 'templates/error-page.php', 'error');                                 // Сторінка помилки
//$router->get('#', '', '#');                                                                               // Заглушка

$router->match();