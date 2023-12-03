<?php
// Маршрутизатор сторінок, пов'язаних з профілем

return [
    'app-name' => 'profile',
    'routers' => [

        'profile' => [                      // Сторінка профилю
            'URL' => '',
            'PATH' => 'index.php',
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['default'],
        ],

        'logout' => [                       // Функція виходу з профілю
            'URL' => 'logout',
            'PATH' => 'logout.php',
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['default'],
        ],

        'passwordEdit' => [                       // Форма зміни паролю
            'URL' => 'password-edit',
            'PATH' => 'passwordEditForm.php',
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['default'],
        ],

    ]
];