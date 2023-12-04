<?php

trait JsonAccessTrait {
    // Трейт для роботи з JSON конфігами

    public static function __callStatic($name, $arguments) {
        // Перевірка наявності файлу конфігурації перед викликом будь-якого методу
        self::checkConfigFileExists();
    }

    public static function getJson(): array {
        // Завантажує та повертає вміст JSON-файлу як масив
        return json_decode(file_get_contents(self::CONFIG_PATH), true);
    }

    public static function setJson(array $data): void {
        // Записує масив у форматі JSON до файлу
        file_put_contents(self::CONFIG_PATH, json_encode($data));
    }

    public static function removeElementJson(string $keyToRemove=null): array {
        // Видаляє елемент з JSON-файлу за заданим ключем
        $result = [];
        foreach (self::getJson() as $key => $value)
            if ($keyToRemove !== null && $key !== $keyToRemove)
                $result[$key] = $value;

        self::setJson($result); // Встановлює значення без видаленного елементу
        return $result;
    }

    public static function editElementJson(string $key, string|int|bool|array|null $value): array {
        // Додає або редагує елемент у JSON-файлі
        $data = self::getJson();
        $data[$key] = $value;
        self::setJson($data);

        return $data;
    }

    public static function getElementJson(string $keyToFind=null): string|int|bool|array|null {
        // Повертає значення елементу за заданим ключем
        foreach (self::getJson() as $key => $value)
            if ($keyToFind !== null && $key === $keyToFind)
                return $value;

        return null; // Якщо в JSON файлі немає елементу по заданому ключу, то повертається null
    }

    public static function isElementJson(string $key): bool {
        // Перевіряє, чи існує елемент у JSON-файлі за заданим ключем
        return array_key_exists($key, self::getJson());
    }

    /*
     * МЕТОДИ ДЛЯ ПЕРЕВІРКИ КОРЕКТНОСТІ РОБОТИ ОСНОВНИХ МЕТОДІВ
     */
    public static function checkConfigFileExists(): void {
        // Перевірити, чи існує файл, до якого метод намагається отримати доступ
        if (!file_exists(self::CONFIG_PATH)) {
            // Створення порожнього JSON файлу, якщо він не існує
            file_put_contents(self::CONFIG_PATH, json_encode(array(), JSON_PRETTY_PRINT));
        }
    }
}