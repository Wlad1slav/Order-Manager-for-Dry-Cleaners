<?php
// Маршрутизатор сторінок, пов'язаних з замовленнями

return [
    'app-name' => 'orders', // Йдеться перед основним посиланням (наприклад orders/rout)
    'routers' => [

        'ordersTable' => [                  // Назва маршруту
            'URL' => '',                    // Посилання, визначення маршруту
            'PATH' => 'index.php',          // Файл, який обробляє запит
            'METHOD' => 'get',              // HTTP-метод сторінки
            'PARAMETERS' => [],             // Обов'язкові парамтри маршруту (наприклад id - orders?id=1)
            'RIGHTS' => ['default'],        // Користувачі з яким рівнем прав можуть перейти по маршрутизатору
        ],

        'switchOrderStatus' => [            // Заміна статусу замовлення
            'URL' => 'switchStatus',
            'PATH' => null,
            'CALL' => ['class' => 'Order', 'method' => 'switchStatus', 'declare' => false],
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['default'],
        ],

        'orderCreate' => [                  // Стоврення нового замовлення
            'URL' => 'new',
            'PATH' => 'create.php',
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['default'],
        ],

        'orderEdit' => [                  // Редагування існуючого замовлення
            'URL' => 'edit',
            'PATH' => 'edit.php',
            'METHOD' => 'get',
            'PARAMETERS' => ['id'],
            'RIGHTS' => ['default'],
        ],

        'orderCreateForm' => [              // Обробка форми створення нового замовлення
            'URL' => 'new',
            'PATH' => null,
            'CALL' => ['class' => 'Order', 'method' => 'create', 'declare' => false],
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['default'],
        ],

        'orderEditForm' => [              // Обробка форми редагування існуючого замовлення
            'URL' => 'edit',
            'PATH' => null,
            'CALL' => ['class' => 'Order', 'method' => 'edit', 'declare' => false],
            'METHOD' => 'post',
            'PARAMETERS' => ['id'],
            'RIGHTS' => ['default'],
        ],

        'orderInvoice' => [                 // Квитанція
            'URL' => 'invoice',
            'PATH' => 'invoice-page.php',
            'METHOD' => 'get',
            'PARAMETERS' => ['id'],
            'RIGHTS' => ['default'],
        ],

        'orderDelete' => [                  // Функція видалення замовлення
            'URL' => 'delete',
            'PATH' => null,
            'CALL' => ['class' => 'Order', 'method' => 'deleteMethod', 'declare' => false],
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['default'],
        ],

        'ordersImport' => [                 // Функція для імпорту замовлень
            'URL' => 'import',
            'PATH' => null,
            'CALL' => ['class' => 'Order', 'method' => 'import', 'declare' => false],
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

        'ordersExport' => [                 // Функція для експорту замовлень
            'URL' => 'export',
            'PATH' => null,
            'CALL' => ['class' => 'Order', 'method' => 'export', 'declare' => false],
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

    ]
];