<?php
global $router;

return [
    "Головна" => ['url' => $router->url('home'), 'right' => 'root'],
    "Замовлення" => ['url' => $router->url('ordersTable'), 'right' => 'default'],
    "Клієнти" => ['url' => $router->url('customersTable'), 'right' => 'default'],
    "Сервіси" => ['url' => $router->url('productsList'), 'right' => 'root'],
    "Аналітика" => ['url' => $router->url('analyticPage'), 'right' => 'root'],
    "Користувачі" => ['url' => $router->url('usersTable'), 'right' => 'root'],
    "Налаштування" => ['url' => $router->url('settingsPage'), 'right' => 'root'],
    "Профіль" => ['url' => $router->url('profile'), 'right' => 'default'],
];