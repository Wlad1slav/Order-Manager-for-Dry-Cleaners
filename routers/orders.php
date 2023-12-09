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
            'PATH' => 'switchStatus.php',
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

        'orderCreateForm' => [              // Обробка форми створення нового замовлення
            'URL' => 'new',
            'PATH' => 'createForm.php',
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['default'],
        ],

        'orderInvoice' => [                 // Квитанція
            'URL' => 'invoice',
            'PATH' => 'invoice-settings.php',
            'METHOD' => 'get',
            'PARAMETERS' => ['id'],
            'RIGHTS' => ['default'],
        ],

    ]
];