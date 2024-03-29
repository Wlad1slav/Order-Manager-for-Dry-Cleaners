<?php
// Маршрутизатор сторінок, пов'язаних з клієнтами

return [
    'app-name' => 'customers',
    'routers' => [

        'customersTable' => [                       // Сторінка з таблицією клієнтів
            'URL' => '',
            'PATH' => 'index.php',
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['default'],
        ],

        'customerCreate' => [                       // Ѳорма створення клієнта
            'URL' => 'create',
            'PATH' => null,
            'CALL' => ['class' => 'Customer', 'method' => 'create', 'declare' => false],
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['default'],
        ],

        'customerEdit' => [                         // Ѳорма редагування клієнта
            'URL' => 'edit',
            'PATH' => null,
            'CALL' => ['class' => 'Customer', 'method' => 'edit', 'declare' => false],
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['default'],
        ],

        'customersImport' => [                      // Форма імпортування клієнтів
            'URL' => 'import',
            'PATH' => null,
            'CALL' => ['class' => 'Customer', 'method' => 'import', 'declare' => false],
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

        'customersExport' => [                      // Метод експорту клієнтів
            'URL' => 'export',
            'PATH' => null,
            'CALL' => ['class' => 'Customer', 'method' => 'export', 'declare' => false],
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

        'customerDelete' => [                       // Функція видалення клієнта
            'URL' => 'delete',
            'PATH' => null,
            'CALL' => ['class' => 'Customer', 'method' => 'deleteMethod', 'declare' => false],
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['default'],
        ],

    ]
];