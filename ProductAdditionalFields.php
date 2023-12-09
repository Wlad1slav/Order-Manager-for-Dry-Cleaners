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
        $this->fields[] = [
            'name' => $name,
            'type' => $type,
            'default' => $default,
            'possibleValues' => $possibleValues
        ];
        Invoice::editJsonConfigElement(['Fields', 'Additional'], [$name => $displayed]);
    }

    public function removeField(int $index): void {
        array_splice($this->fields, $index, 1);
    }

    public function editField(string $index, string $element, string|bool|int $value): void {
        /*
        $index - номер додаткового поля
        $element - елемент, який в долатковому полі треба змінити
        $value - нове значення
        */
        $this->fields[$index][$element] = $value;
    }

    public function getInvoicePositiveFields(): array {
        $result = [];

        foreach ($this->fields as $field)
            if ($field['displayedOnInvoice'] === true)
                $result[] = $field;

        return $result;
    }

    public function save(): void {
        // Метод, що зберігає масив полів у json файлі
        self::setJsonConfig($this->fields);
    }

    public function generateHTML(array $field, int $fieldNum, $productNum): string {
        // Генерує додаткові поля для замовлення
        switch ($field['type']) {
            case 'dropdown': // Не використовується
                return $this->generateDropdown($field, $fieldNum, $productNum);
            case 'number':
            case 'text':
            case 'textarea':
                return $this->generateInputOrTextarea($field, $fieldNum, $productNum);
            case 'checkbox':
                return $this->generateCheckbox($field, $fieldNum, $productNum);
            case 'radio':
                return $this->generateRadio($field, $fieldNum, $productNum);
            default:
                return print_r($field, true);
        }
    }

    private function generateDropdown(array $field, int $fieldNum, int $productNum): string {
        // SELECT
        // Не використовується
        $label = $this->generateLabel($field['name'], $fieldNum, $productNum);
        $input = "<select id='additionalPropertie-$fieldNum-$productNum'>";
        foreach ($field['possibleValues'] as $option) {
            $input .= "<option value='$option'>$option</option>";
        }
        $input .= "</select>";
        return $label . $input;
    }

    private function generateInputOrTextarea(array $field, int $fieldNum, int $productNum): string {
        // TEXT, NUMBER, TEXTAREA
        $label = $this->generateLabel($field['name'], $fieldNum, $productNum);
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

    private function generateCheckbox(array $field, int $fieldNum, int $productNum): string {
        // CHECKBOXES
        $label = $this->generateLabel($field['name'], $fieldNum, $productNum);
        $input = "";
        $optionNum = 0;
        foreach ($field['possibleValues'] as $option) {
            $optionNum++;
            $input .= "<label><input type='{$field['type']}' value='$option' id='additionalPropertie-$optionNum-$fieldNum-$productNum' name='additionalPropertie-$fieldNum-$productNum" . "[]'>$option</label>";
        }
        return $label . $input;
    }

    private function generateRadio(array $field, int $fieldNum, int $productNum): string {
        // RADIO
        // На розділ від checkboxes, в name не додаються []
        $label = $this->generateLabel($field['name'], $fieldNum, $productNum);
        $input = "";
        $optionNum = 0;
        foreach ($field['possibleValues'] as $option) {
            $optionNum++;
            $input .= "<label><input type='{$field['type']}' value='$option' id='additionalPropertie-$optionNum-$fieldNum-$productNum' name='additionalPropertie-$fieldNum-$productNum'>$option</label>";
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

    public function addAdditionalField_routeCall(): string {
        // fieldAdd маршрут
        // Збереження швидкого вибору нотаток

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

        return 'settingsPage'; // Куди повинен повертатися користувач
    }

    public function removeAdditionalField_routeCall(): string {
        // fieldRemove маршрут
        // Збереження швидкого вибору нотаток

        if (isset($_GET['index']))
            $fieldIndex = intval($_GET['index']);
        else {
            $_SESSION['error'] = '<b>Помилка при видаленні додаткового поля</b><br> Не був вказаний індекс додаткового поля.';
            return 'settingsPage';
        }

        try {
            $this->removeField($fieldIndex);
            $this->save();
        } catch (Exception $e) {
            $_SESSION['error'] = "<b>Помилка при видаленні додаткового поля</b><br> $e.";
        }

        return 'settingsPage'; // Куди повинен повертатися користувач
    }

}