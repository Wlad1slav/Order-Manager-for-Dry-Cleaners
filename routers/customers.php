<?php
// Маршрутизатор сторінок, пов'язаних з клієнтами

return [
    'app-name' => 'customers',
    'routers' => [

        'customersTable' => [                       // Сторінка з таблицією користувачів
            'URL' => '',
            'PATH' => 'index.php',
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['default'],
        ],

        'customerCreate' => [                       // Сторінка з таблицією користувачів
            'URL' => 'create',
            'PATH' => 'createForm.php',
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['default'],
        ],

        'customerEdit' => [                         // Сторінка з таблицією користувачів
            'URL' => 'edit',
            'PATH' => 'editForm.php',
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['default'],
        ],

        'customersImport' => [                      // Форма імпортування клієнтів
            'URL' => 'import',
            'PATH' => 'importForm.php',
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['default'],
        ],

        'customerDelete' => [                       // Функція видалення клієнта
            'URL' => 'delete',
            'PATH' => 'delete.php',
            'METHOD' => 'get',
            'PARAMETERS' => ['id'],
            'RIGHTS' => ['default'],
        ],

    ]
];