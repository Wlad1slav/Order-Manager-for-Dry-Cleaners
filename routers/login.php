<?php

return [
    'app-name' => 'login',
    'routers' => [

        'login' => [                // Сторінка авторизації
            'URL' => '',
            'PATH' => 'index.php',
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => [],
        ],

        'auth' => [                 // Форма авторизації
            'URL' => '',
            'PATH' => 'loginForm.php',
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => [],
        ],

    ]
];