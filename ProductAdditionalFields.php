<?php

class ProductAdditionalFields {
    const TYPES = [                     // Можливі типи полів
        'text',
        'textarea',
        'number',
        'dropdown',
        'checkbox',
        'radio',
    ];

    const CONFIG_PATH = 'settings/productAdditionalFields.json';

    private array $fields;

    public function __construct() {
        $this->fields = $this->getJson();
    }

    public function addField(string $name, string $type, string $default = '', array $possibleValues = []): void {
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
    }

    public function removeField(int $index): void {
        array_splice($this->fields, $index, 1);
    }

    private function fieldExists(string $name): bool {
        foreach ($this->fields as $field) {
            if ($field['name'] === $name) {
                return true;
            }
        }
        return false;
    }

    public function convertFieldsToJson(): string {
        // Метод, що конвертує масив у json формат
        return json_encode($this->fields);
    }

    public function save(): void {
        // Метод, що зберігає масив полів у json файлі
        $data = $this->convertFieldsToJson();
        file_put_contents($this::CONFIG_PATH, $data);
    }

    public static function getJson(): array {
        // Метод, що повертає дані о полях з json у форматі масиву
        return json_decode(file_get_contents(self::CONFIG_PATH), true) ?? [];
    }

    public function generateHTML(array $field, int $fieldNum, $productNum): string {
        // Генерує додаткові поля для замовлення
        switch ($field['1']) {
            case 'dropdown':
                return $this->generateDropdown($field, $fieldNum, $productNum);
            case 'number':
            case 'text':
            case 'textarea':
                return $this->generateInputOrTextarea($field, $fieldNum, $productNum);
            case 'checkbox':
            case 'radio':
                return $this->generateCheckboxOrRadio($field, $fieldNum, $productNum);
            default:
                return print_r($field, true);
        }
    }

    private function generateDropdown(array $field, int $fieldNum, int $productNum): string {
        // SELECT
        $label = $this->generateLabel($field[0], $fieldNum, $productNum);
        $input = "<select id='additionalPropertie-$fieldNum-$productNum'>";
        foreach ($field[3] as $option) {
            $input .= "<option value='$option'>$option</option>";
        }
        $input .= "</select>";
        return $label . $input;
    }

    private function generateInputOrTextarea(array $field, int $fieldNum, int $productNum): string {
        // TEXT, NUMBER, TEXTAREA
        $label = $this->generateLabel($field[0], $fieldNum, $productNum);
        if ($field[1] === 'textarea') {
            $input = "<textarea id='additionalPropertie-$fieldNum-$productNum' name='additionalPropertie-$fieldNum-$productNum'></textarea>";
        } else {
            $input = "<input type='{$field['1']}' list='additionalPropertie-datalist-$fieldNum-$productNum' id='additionalPropertie-$fieldNum-$productNum' name='additionalPropertie-$fieldNum-$productNum'>";
            if (!empty($field[3])) {
                $input .= "<datalist id='additionalPropertie-datalist-$fieldNum-$productNum'>";
                foreach ($field[3] as $option) {
                    $input .= "<option value='$option'>$option</option>";
                }
                $input .= "</datalist>";
            }
        }
        return $label . $input;
    }

    private function generateCheckboxOrRadio(array $field, int $fieldNum, int $productNum): string {
        // CHECKBOX, RADIO
        $label = $this->generateLabel($field[0], $fieldNum, $productNum);
        $input = "";
        $optionNum = 0;
        foreach ($field['3'] as $option) {
            $optionNum++;
            $input .= "<label><input type='{$field[1]}' value='$option' id='additionalPropertie-$optionNum-$fieldNum-$productNum' name='additionalPropertie-$fieldNum-$productNum'>$option</label>";
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

}