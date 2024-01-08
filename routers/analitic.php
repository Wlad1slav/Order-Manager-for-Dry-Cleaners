<?php
// Маршрутизатор сторінок, пов'язаних з аналітикою товарів

return [
    'app-name' => 'analytic',
    'routers' => [

        'analyticPage' => [
            // Сторінка аналітики
            'URL' => '',
            'PATH' => 'index.php',
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

        'ordersByDate' => [
            // Сторінка з таблицею замовлень за певний день
            'URL' => 'orders-per',
            'PATH' => 'ordersByDate.php',
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],
    ]
];