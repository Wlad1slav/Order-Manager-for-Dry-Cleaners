<?php
// Маршрутизатор сторінок, пов'язаних з налаштуваннями

return [
    'app-name' => 'app-settings',
    'routers' => [

        'settingsPage' => [
            // Сторінка налаштувань
            'URL' => '',
            'PATH' => 'index.php',
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

        'fieldAdd' => [
            // Форма додаваня додаткового поля для виробу
            'URL' => 'field/add',
            'PATH' => null,
            'CALL' => ['class' => 'ProductAdditionalFields', 'method' => 'addAdditionalField_routeCall', 'declare' => true],
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

        'fieldRemove' => [
            // Функція видалення додаткового поля для виробу
            'URL' => 'field/delete',
            'PATH' => null,
            'CALL' => ['class' => 'ProductAdditionalFields', 'method' => 'removeAdditionalField_routeCall', 'declare' => true],
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

        'fieldStatus' => [
            // Функція зміни статусу додаткового поля
            'URL' => 'field/switch-status',
            'PATH' => null, //'additionalFieldSwitchStatus.php',
            'CALL' => ['class' => 'Invoice', 'method' => 'switchFieldViewStatus', 'declare' => false],
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

        'notesFieldSave' => [
            // Форма збереження швидкого вибору приміток для виробу
            'URL' => 'notes/save',
            'PATH' => null,
            'CALL' => ['class' => 'Order', 'method' => 'savingQuickSelectionNotes_routeCall', 'declare' => false],
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

        'editProductsAmount' => [
            // Форма збереження кількісоті виробів в замовлені
            'URL' => 'amount/set',
            'PATH' => null,
            'CALL' => ['class' => 'Order', 'method' => 'savingProductAmount_routeCall', 'declare' => false],
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

        'editDeadline' => [
            // Форма збереження кількісоті виробів в замовлені
            'URL' => 'deadline/set',
            'PATH' => null,
            'CALL' => ['class' => 'Order', 'method' => 'savingDeadlineDuration_routeCall', 'declare' => false],
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

        'editInvoiceImage' => [
            // Форма форма редагування зображення квитанції (чи показується воно, яке зображення)
            'URL' => 'invoice/image',
            'PATH' => null,
            'CALL' => ['class' => 'Invoice', 'method' => 'setImageSettings_routeCall', 'declare' => false],
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

        'editInvoiceInfo' => [
            // Форма форма редагування інформації, що показується в квитанції
            'URL' => 'invoice/info',
            'PATH' => null,
            'CALL' => ['class' => 'Invoice', 'method' => 'setInfoSettings_routeCall', 'declare' => false],
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

        'editInvoiceAmount' => [
            // Форма форма редагування кількості квитанцій на однієй сторінці
            'URL' => 'invoice/amount',
            'PATH' => null,
            'CALL' => ['class' => 'Invoice', 'method' => 'setAmountSettings_routeCall', 'declare' => false],
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

        'editInvoiceCurrentSettings' => [
            // Запрос для переключення параметру current в налаштуваннях квитанції
            'URL' => 'app-settings/invoice/current-settings/set',
            'PATH' => null,
            'CALL' => ['class' => 'Invoice', 'method' => 'setCurrentSettings_routeCall', 'declare' => false],
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

    ]
];