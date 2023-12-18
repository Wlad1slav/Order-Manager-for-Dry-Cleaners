<?php
require_once 'ProductAdditionalFields.php';

class Invoice {
    use JsonAccessTrait;    // Трейт для операцій з json файлами

    // Константи для роботи з конфігом
    const CONFIG_PATH = 'settings/config_invoice.json'; // Шлях до конфігу
    const CONFIG_DEFAULT = [
        'Current' => false, // false - квитанції будуть показуватися з налаштуваннями, що були актуалі на момент їх створення
        'Amount' => 1, // Кількість квитанцій на однієй сторінці
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
                'amount' => ['displayed' => true, 'localization' => 'Кількість'],
                'price' => ['displayed' => true, 'localization' => 'Ціна'],
                'discount' => ['displayed' => false, 'localization' => 'Знижка'],
                'note' => ['displayed' => true, 'localization' => 'Нотатки'],
            ],
            'Additional' => []
        ]
    ];

    public static function switchFieldViewStatus() {
        // fieldStatus маршрут
        // Змінює статус видимості поля

        $fieldIndex = $_GET['fieldIndex'];
        $fieldType = $_GET['fieldType'];

        $newData = self::editJsonConfigElement(
            ['Fields', $fieldType, $fieldIndex, 'displayed'],
            !self::getJsonConfigElement('Fields')[$fieldType][$fieldIndex]['displayed'] // Протилежно тому статусу, що є
        );

        self::setJsonConfig($newData);

        return null;
    }

    public static function setImageSettings_routeCall(): ?array {
        // editInvoiceImage маршрут
        // Змінює налаштування зображення в квитанції

        $displayedInvoiceImgStatus = $_POST['displayed-invoice-img'];

        // Встановлює видимість зображення
        $newData = self::editJsonConfigElement(
            ['Image', 'displayed'],
            $displayedInvoiceImgStatus
        );
        self::setJsonConfig($newData);

        // Перевіряє, чи файл є дійсним зображенням
        if ($_FILES["invoice-img"]['size'] > 0) { // Якщо зображення завантаженно
            $check = getimagesize($_FILES["invoice-img"]["tmp_name"]);
            if ($check !== false) $uploadOk = 1;
            else  $uploadOk = 0;

            if ($uploadOk == 0)
                $_SESSION['error'] = '<b>Помилка при завантажені зображення:</b><br> Ви намагаєтесь завантажити не зображення.';

            // Завантажує зображення
            if (!move_uploaded_file($_FILES["invoice-img"]["tmp_name"], self::getJsonConfigElement('Image')['path']))
                $_SESSION['error'] = '<b>Помилка при завантажені зображення:</b><br> Щось пішло не так.';
        }

        return [
            'rout-name' => 'settingsPage',
            'rout-params' => []
        ];
    }

    public static function setInfoSettings_routeCall(): ?array {
        // editInvoiceInfo маршрут
        // Редагує додаткову інформацію в квитанції

        self::setJsonConfig(self::editJsonConfigElement(
            // Інформація про ваш бізнес
            ['Text', 'Information', 'Business'],
            $_POST['business-info']
        ));

        self::setJsonConfig(self::editJsonConfigElement(
        // Адреса вашого бізнесу
            ['Text', 'Information', 'Address'],
            $_POST['address-info']
        ));

        self::setJsonConfig(self::editJsonConfigElement(
        // Номер телефону вашого бізнесу
            ['Text', 'Information', 'Phone'],
            $_POST['phone-info']
        ));

        self::setJsonConfig(self::editJsonConfigElement(
        // Пошта вашого бізнесу
            ['Text', 'Information', 'Email'],
            $_POST['email-info']
        ));

        self::setJsonConfig(self::editJsonConfigElement(
        // Додаткова інформація зверху
            ['Text', 'Start'],
            $_POST['top-text']
        ));

        self::setJsonConfig(self::editJsonConfigElement(
        // Додаткова інформація знизу
            ['Text', 'End'],
            $_POST['bottom-text']
        ));

        return [
            'rout-name' => 'settingsPage',
            'rout-params' => []
        ];
    }

    public static function setAmountSettings_routeCall(): ?array {
        // Встановлює кількість квитанцій на однієй сторінці

        self::setJsonConfig(self::editJsonConfigElement(
            ['Amount'],
            $_POST['invoice-amount']
        ));

        return [
            'rout-name' => 'settingsPage',
            'rout-params' => []
        ];
    }

    public static function setCurrentSettings_routeCall(): ?array {
        // Встановлює кількість квитанцій на однієй сторінці

        self::setJsonConfig(self::editJsonConfigElement(
            ['Current'],
            $_GET['current']
        ));

        return [
            'rout-name' => 'settingsPage',
            'rout-params' => []
        ];
    }
}