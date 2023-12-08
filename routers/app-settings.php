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

//        'switchStandardFieldViewStatus' => [
//            // Функція зміни статусу стандартного поля
//            'URL' => 'standard-field/switch-status',
//            'PATH' => null,
//            'CALL' => ['class' => 'Invoice', 'method' => 'switchFieldViewStatus', 'declare' => false],
//            'METHOD' => 'get',
//            'PARAMETERS' => [],
//            'RIGHTS' => ['root'],
//        ],

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

    ]
];