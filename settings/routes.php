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
$router->get(ORDER_APP, "templates/" .ORDER_APP. "/index.php", 'ordersTable');                          // Сторінка з усіма замовленнями
$router->get(                                                                                                              // Сторінка зміни статусу замовлення
    ORDER_APP . '/switchStatus', 'templates/' .ORDER_APP. '/switchStatus.php', 'switchOrderStatus'
);
$router->get(ORDER_APP . '/new', 'templates/' .ORDER_APP. '/create.php', 'orderCreate');                // Сторінка створення замовлення

// КЛІЄНТИ
const CUSTOMERS_APP = 'customers';
$router->get(CUSTOMERS_APP, 'templates/' .CUSTOMERS_APP. '/index.php', 'customersTable');                       // Сторінка з усіма клієнтами
$router->post(CUSTOMERS_APP, 'templates/' .CUSTOMERS_APP. '/createForm.php', 'customerCreate');                 // Форма створення нового клієнта
$router->post(CUSTOMERS_APP.'/edit', 'templates/' .CUSTOMERS_APP. '/editForm.php', 'customerEdit');             // Форма редагування клієнта
$router->post(CUSTOMERS_APP.'/import', 'templates/' .CUSTOMERS_APP. '/importForm.php', 'customersImport');      // Форма іморту клієнта
$router->get(CUSTOMERS_APP.'/delete', 'templates/' .CUSTOMERS_APP. '/delete.php', 'customerDelete');            // Видалення клієнта

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