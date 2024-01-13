<?php
global $router;

return [
    "Головна" => $router->url('home'),
    "Замовлення" => $router->url('ordersTable'),
    "Клієнти" => $router->url('customersTable'),
    "Сервіси" => $router->url('productsList'),
    "Аналітика" => $router->url('analyticPage'),
    "Користувачі" => $router->url('usersTable'),
    "Налаштування" => $router->url('settingsPage'),
    "Профіль" => $router->url('profile'),
];