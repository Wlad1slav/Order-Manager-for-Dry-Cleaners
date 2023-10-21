<?php
require_once 'Rights.php';

$all = [
    'homepage' =>   ['view'],                                                       // Головна сторінка
    'orders' =>     ['view', 'create', 'delete', 'edit', 'export', 'import'],       // Замовлення
    'customers' =>  ['view', 'create', 'delete', 'edit', 'export', 'import'],       // Клієнти
    'users' =>      ['view', 'create', 'delete'],                                   // Сервіси
    'products' =>   ['view', 'export', 'import'],                                   // Користувачі
    'analytic' =>   ['view', 'export'],                                             // Аналітика
    'settings' =>   ['view', 'edit'],                                               // Налаштування
];

//include 'Rights.php';
return [
    new Rights(1, 'root', $all),        // Супер користувач
    new Rights(2, 'worker', [           // Працівник
        'homepage' =>   ['view'],
        'orders' =>     ['view', 'create', 'edit'],
        'customers' =>  ['view', 'create', 'edit'],
        'products' =>   ['view'],
    ])
];
