<?php
require_once 'Invoice.php';

class ProductAdditionalFields {
    use JsonAccessTrait;    // Трейт для операцій з json файлами
    // Константи для роботи з конфігом
    const CONFIG_PATH = 'settings/config_additional_fields.json';
    const CONFIG_DEFAULT = [];

    const TYPES = [ // Можливі типи полів
        'text',
        'textarea',
        'number',
        'checkbox',
        'radio',
    ];

    private array $fields;

    public function __construct() {
        $this->fields = self::getJsonConfig() ?? []; // Якщо повертається null, то надається пустий масив
    }

    public function addField(string $name, string $type, string $default = '', array $possibleValues = [], bool $displayed = false): void {
        // Мето, що додає поле до масива полів
        foreach ($this->fields as $field) {
            if ($field['0'] == $name)
                throw new InvalidArgumentException("addField(string $name, string $type, string $default = '', array possibleValues = []): Поле з назвою $name вже існує.");
            if (!in_array($type, $this::TYPES))
                throw new InvalidArgumentException("addField(string $name, string $type, string $default = '', array possibleValues = []): Некоретний \"$type\" тип поля.");
        }
        $this->fields[$name] = [
            'type' => $type,
            'default' => $default,
            'possibleValues' => $possibleValues
        ];
        Invoice::editJsonConfigElement(['Fields', 'Additional', $name],  ['displayed'=>$displayed]);
    }

    public function removeField(string $key): void {
        unset($this->fields[$key]);
        Invoice::deleteJsonConfigElement(['Fields', 'Additional', $key]);
    }

    public function editField(string $index, string $element, string|bool|int $value): void {
        /*
        $index - номер додаткового поля
        $element - елемент, який в долатковому полі треба змінити
        $value - нове значення
        */
        $this->fields[$index][$element] = $value;
    }

    public function getInvoicePositiveFields($config, $fields = null): array {
        if ($fields === null)
            $fields = $this->fields;

        $result = [];

        foreach ($config['Fields']['Additional'] as $fieldName=>$fieldInfo)
            if ($fieldInfo['displayed'] === true)
                $result[$fieldName] = $fields[$fieldName];

        return $result;
    }

    public function save(): void {
        // Метод, що зберігає масив полів у json файлі
        self::setJsonConfig($this->fields);
    }

    public function generateHTML(string $fieldName, array $fieldInfo, int $fieldNum, $productNum): string {
        // Генерує додаткові поля для замовлення
        switch ($fieldInfo['type']) {
            case 'number':
            case 'text':
            case 'textarea':
                return $this->generateInputOrTextarea($fieldName, $fieldInfo, $fieldNum, $productNum);
            case 'checkbox':
                return $this->generateCheckbox($fieldName, $fieldInfo, $fieldNum, $productNum);
            case 'radio':
                return $this->generateRadio($fieldName, $fieldInfo, $fieldNum, $productNum);
            default:
                return print_r($fieldInfo, true);
        }
    }

    private function generateInputOrTextarea(string $name, array $field, int $fieldNum, int $productNum): string {
        // TEXT, NUMBER, TEXTAREA
        $label = $this->generateLabel($name, $fieldNum, $productNum);
        if ($field['type'] === 'textarea') {
            $input = "<textarea id='additionalPropertie-$fieldNum-$productNum' name='additionalPropertie-$fieldNum-$productNum'>{$field['default']}</textarea>";
        } else {
            $input = "<input type='{$field['type']}' list='additionalPropertie-datalist-$fieldNum-$productNum' id='additionalPropertie-$fieldNum-$productNum' name='additionalPropertie-$fieldNum-$productNum' value='{$field['default']}'>";
            if (!empty($field['possibleValues'])) {
                $input .= "<datalist id='additionalPropertie-datalist-$fieldNum-$productNum'>";
                foreach ($field['possibleValues'] as $option) {
                    $input .= "<option value='$option'>$option</option>";
                }
                $input .= "</datalist>";
            }
        }
        return $label . $input;
    }

    private function generateCheckbox(string $name, array $field, int $fieldNum, int $productNum): string {
        // CHECKBOXES
        $label = $this->generateLabel($name, $fieldNum, $productNum);
        $input = "";
        $optionNum = 0;
        foreach ($field['possibleValues'] as $option) {
            $optionNum++;
            $input .= "<label><input type='$name' value='$option' id='additionalPropertie-$optionNum-$fieldNum-$productNum' name='additionalPropertie-$fieldNum-$productNum" . "[]'>$option</label>";
        }
        return $label . $input;
    }

    private function generateRadio(string $name, array $field, int $fieldNum, int $productNum): string {
        // RADIO
        // На розділ від checkboxes, в name не додаються []
        $label = $this->generateLabel($name, $fieldNum, $productNum);
        $input = "";
        $optionNum = 0;
        foreach ($field['possibleValues'] as $option) {
            $optionNum++;
            $input .= "<label><input type='$name' value='$option' id='additionalPropertie-$optionNum-$fieldNum-$productNum' name='additionalPropertie-$fieldNum-$productNum'>$option</label>";
        }
        return $label . $input;
    }

    private function generateLabel(string $name, int $fieldNum, int $productNum): string {
        // LABEL
        return "<label for='additionalPropertie-$fieldNum-$productNum'>$name</label>";
    }

    public function getFields(): array {
        // Повертає масив полів
        return $this->fields;
    }

    public function countExistingFields(): int {
        // Повертає масив полів
        return count($this->fields);
    }

    // Методи для виклику зовні, користувачем

    public function addAdditionalField_routeCall(): array {
        // fieldAdd маршрут
        // Додання додаткового полю до замовлення

        $fieldName = $_POST['fieldName'] ?? null;
        $fieldType = $_POST['fieldType'] ?? null;
        $defaultFieldValue = $_POST['defaultFieldValue'] ?? null;
        $availableValues = $_POST['availableValues'] ?? null;
        $availableValues = explode(',', $availableValues);

        try {
            $this->addField($fieldName, $fieldType, $defaultFieldValue, $availableValues, false);
            $this->save();
        } catch (Exception $e) {
            $_SESSION['error'] = '<b>Помилка при створенні додаткового поля</b><br>' . $e->getMessage();
        }

        return [
            'rout-name' => 'settingsPage',
            'rout-params' => [],
            'page-section' => 'additional-fields'
        ];
    }

    public function removeAdditionalField_routeCall(): array {
        // fieldRemove маршрут
        // Збереження швидкого вибору нотаток

        if (isset($_GET['field']))
            $fieldName = $_GET['field'];
        else {
            $_SESSION['error'] = '<b>Помилка при видаленні додаткового поля</b><br> Не був вказаний індекс додаткового поля.';
            return [
                'rout-name' => 'settingsPage',
                'rout-params' => [],
            ];
        }

//        Invoice::deleteJsonConfigElement(['Fields', 'Additional', $fieldIndex]);

        try {
            $this->removeField($fieldName);
            $this->save();
        } catch (Exception $e) {
            $_SESSION['error'] = "<b>Помилка при видаленні додаткового поля</b><br> $e.";
        }

        return [
            'rout-name' => 'settingsPage',
            'rout-params' => [],
            'page-section' => 'additional-fields'
        ];
    }

}