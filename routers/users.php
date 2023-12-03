<?php
// Маршрутизатор сторінок, пов'язаних з користувачами

return [
    'app-name' => 'users',
    'routers' => [

        'usersTable' => [                   // Таблиця з користувачами
            'URL' => '',
            'PATH' => 'index.php',
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

        'userCreate' => [                   // Форма створення користувача
            'URL' => 'create',
            'PATH' => 'createForm.php',
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

        'userDelete' => [                   // Функція видалення користувача
            'URL' => 'delete',
            'PATH' => 'delete.php',
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

    ]
];