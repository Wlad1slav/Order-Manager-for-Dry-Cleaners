<?php
// Маршрутизатор сторінок, пов'язаних з продукцією

return [
    'app-name' => 'products',
    'routers' => [

        'productsList' => [                 // Таблиця з продукцією
            'URL' => '',
            'PATH' => 'index.php',
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['default'],
        ],

        'productsImport' => [               // Форма для імпорту продукції
            'URL' => 'importForm',
            'PATH' => 'importForm.php',
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['default'],
        ],

    ]
];