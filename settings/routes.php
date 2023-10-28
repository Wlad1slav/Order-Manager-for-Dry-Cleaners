<?php
/**     @var $router
        МАРШРУТИЗАЦІЯ СТОРІНОК
*/

// КОРИСТУВАЧІ
const LOGIN_APP = 'login';
$router->get(LOGIN_APP, 'templates/' .LOGIN_APP. '/index.php', 'login');                                        // Сторінка авторизації
$router->post(LOGIN_APP, 'templates/' .LOGIN_APP. '/loginForm.php', 'auth');                                    // Форма авторизації

const PROFILE_APP = 'profile';
$router->get(PROFILE_APP, 'templates/' .PROFILE_APP. '/index.php', 'profile');                                  // Сторінка профілю
$router->get(PROFILE_APP. '/logout', 'templates/' .PROFILE_APP. '/logout.php', 'logout');                       // Виход з акаунту
$router->post(PROFILE_APP, 'templates/' .PROFILE_APP. '/passwordEditForm.php', 'passwordEdit');                 // Форма зміни паролю

const USERS_APP = 'users';
$router->get(USERS_APP, 'templates/' .USERS_APP. '/index.php', 'usersTable');                                   // Перелік усіх користувачів
$router->post(USERS_APP, 'templates/' .USERS_APP. '/createForm.php', 'userCreate');                             // Форма створення нового користувача
$router->get(USERS_APP . '/delete', 'templates/' .USERS_APP. '/delete.php', 'userDelete');                      // Вилучення користувача

// ЗАМОВЛЕННЯ
const ORDER_APP = 'orders';
$router->get(ORDER_APP, "templates/" .ORDER_APP. "/index.php", 'ordersTable');                                  // Сторінка з усіма замовленнями
$router->get(ORDER_APP . '/switchStatus', 'templates/' .ORDER_APP. '/switchStatus.php', 'switchOrderStatus');   // Сторінка зміни статусу замовлення
$router->get(ORDER_APP . '/new', 'templates/' .ORDER_APP. '/create.php', 'orderCreate');                        // Сторінка створення замовлення
$router->post(ORDER_APP . '/new', 'templates/' .ORDER_APP. '/createForm.php', 'orderCreateForm');               // Форма створення замовлення

// КЛІЄНТИ
const CUSTOMERS_APP = 'customers';
$router->get(CUSTOMERS_APP, 'templates/' .CUSTOMERS_APP. '/index.php', 'customersTable');                       // Сторінка з усіма клієнтами
$router->post(CUSTOMERS_APP, 'templates/' .CUSTOMERS_APP. '/createForm.php', 'customerCreate');                 // Форма створення нового клієнта
$router->post(CUSTOMERS_APP.'/edit', 'templates/' .CUSTOMERS_APP. '/editForm.php', 'customerEdit');             // Форма редагування клієнта
$router->post(CUSTOMERS_APP.'/import', 'templates/' .CUSTOMERS_APP. '/importForm.php', 'customersImport');      // Форма іморту клієнта
$router->get(CUSTOMERS_APP.'/delete', 'templates/' .CUSTOMERS_APP. '/delete.php', 'customerDelete');            // Видалення клієнта

// СЕРВІСИ
const PRODUCTS_APP = 'products';
$router->get(PRODUCTS_APP, 'templates/' .PRODUCTS_APP. '/index.php', 'productsList');                           // Сторінка з усіма сервісами
$router->post(PRODUCTS_APP, 'templates/' .PRODUCTS_APP. '/importForm.php', 'productsImport');                   // Сторінка з усіма сервісами

// НАЛАШТУВАННЯ
const SETTINGS_APP = 'app-settings';
$router->get(SETTINGS_APP, 'templates/' .SETTINGS_APP. '/index.php', 'settingsPage');                           // Сторінка з налаштуваннями
$router->post(SETTINGS_APP, 'templates/' .SETTINGS_APP. '/additionalFieldCreateForm.php', 'fieldAdd');          // Форма, що додає нове додаткове поле замовлення
$router->get('order-field/delete', 'templates/' .SETTINGS_APP. '/additionalFieldRemove.php', 'fieldRemove');    // Видалення додаткового поля замовлення

// ІНШЕ
$router->get('error', 'templates/error-page.php', 'error');                                                     // Сторінка помилки

$router->match();