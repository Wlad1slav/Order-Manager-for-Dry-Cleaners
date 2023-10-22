<?php

class ProductAdditionalFields {
    const TYPES = [                     // Можливі типи полів
        'text',
        'textarea',
        'num',
        'dropdown',
        'checkboxes',
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
        $this->fields[] = [$name, $type, $default, $possibleValues];
    }

    public function removeField(int $index): void {
        array_splice($this->fields, $index, 1);
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
        return json_decode(file_get_contents(self::CONFIG_PATH));
    }

//    public static function generateHTML(array $field): string {
//        $result = '';
//    }

    public function getFields(): array {
        // Повертає масив полів
        return $this->fields;
    }

}