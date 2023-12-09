<?php
require_once 'ProductAdditionalFields.php';

class Invoice {
    use JsonAccessTrait;    // Трейт для операцій з json файлами

    // Константи для роботи з конфігом
    const CONFIG_PATH = 'settings/config_invoice.json'; // Шлях до конфігу
    const CONFIG_DEFAULT = [
        'Image' => [
            'displayed' => true,
            'path' => '/static/images/invoice_image.png'
        ],
        'Text' => [
            'Information' => [
                'Business' => 'ФОП Призвище Ім\'я По батькові, ІПН 0000000000 <br>Підприємство "Назва"',
                'Address' => 'Район р-н, с.Село, вул. Вулиця 1а',
                'Phone' => '(000) 000-00-00',
                'Email' => 'email@gmail.com'
            ],
            'Start' => '',
            'End' => ''
        ],
        'Fields' => [
            'Standard' => [
                'note' => ['displayed' => true, 'localization' => 'Нотатки'],
                'price' => ['displayed' => true, 'localization' => 'Ціна'],
                'amount' => ['displayed' => true, 'localization' => 'Кількість'],
                'discount' => ['displayed' => false, 'localization' => 'Знижка']
            ],
            'Additional' => []
        ]
    ];

    public static function switchFieldViewStatus(): void {
        // fieldStatus маршрут
        // Змінює статус видимості поля

        $fieldIndex = $_GET['fieldIndex'];
        $fieldType = $_GET['fieldType'];

        $newData = self::editJsonConfigElement(
            ['Fields', $fieldType, $fieldIndex, 'displayed'],
            !self::getJsonConfigElement('Fields')[$fieldType][$fieldIndex]['displayed'] // Протилежно тому статусу, що є
        );

        self::setJsonConfig($newData);
    }
}