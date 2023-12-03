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
            'PATH' => 'additionalFieldCreateForm.php',
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

        'fieldRemove' => [
            // Функція видалення додаткового поля для виробу
            'URL' => 'field/delete',
            'PATH' => 'additionalFieldRemove.php',
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

        'fieldStatus' => [
            // Функція зміни статусу додаткового поля
            'URL' => 'field/switch-status',
            'PATH' => 'additionalFieldSwitchStatus.php',
            'METHOD' => 'get',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

        'notesFieldSave' => [
            // Форма збереження швидкого вибору приміток для виробу
            'URL' => 'notes/save',
            'PATH' => 'notesFieldSave.php',
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

        'editProductsAmount' => [
            // Форма збереження кількісоті виробів в замовлені
            'URL' => 'amount/set',
            'PATH' => 'productsAmountSave.php',
            'METHOD' => 'post',
            'PARAMETERS' => [],
            'RIGHTS' => ['root'],
        ],

    ]
];