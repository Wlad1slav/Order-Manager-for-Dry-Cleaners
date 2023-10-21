<?php
global $router;

return [
    "Головна" => '/',
    "Замовлення" => $router->url('ordersTable'),
    "Клієнти" => $router->url('customersTable'),
    "Сервіси" => $router->url('productsList'),
    "Аналітика" => "/analytic",
    "Користувачі" => $router->url('usersTable'),
    "Налаштування" => "/settings",
    "Профіль" => $router->url('profile'),
];