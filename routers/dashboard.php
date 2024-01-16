<?php
// Маршрутизатор сторінки Dashboard

return [
    'app-name' => 'dashboard',
    'routers' => [

        'home' => [
            'URL' => '',
            'PATH' => 'index.php',
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['default'],
        ],
    ]
];