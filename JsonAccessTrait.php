<?php

trait JsonAccessTrait {
    // Трейт для роботи з JSON конфігами

    public static function getJsonConfig(): array {
        // Завантажує та повертає вміст JSON-файлу як масив
        self::checkJsonConfigFileExists();
        return json_decode(file_get_contents(self::CONFIG_PATH), true);
    }

    public static function setJsonConfig(array $data): void {
        // Записує масив у форматі JSON до файлу
        self::checkJsonConfigFileExists();
        file_put_contents(self::CONFIG_PATH, json_encode($data));
    }

    public static function removeElementJson(string $keyToRemove=null): array {
        // Видаляє елемент з JSON-файлу за заданим ключем
        self::checkJsonConfigFileExists();
        $result = [];
        foreach (self::getJsonConfig() as $key => $value)
            if ($keyToRemove !== null && $key !== $keyToRemove)
                $result[$key] = $value;

        self::setJsonConfig($result); // Встановлює значення без видаленного елементу
        return $result;
    }

    public static function editJsonConfigElement(string $key, string|int|bool|array|null $value): array {
        // Додає або редагує елемент у JSON-файлі
        self::checkJsonConfigFileExists();
        $data = self::getJsonConfig();
        $data[$key] = $value;
        self::setJsonConfig($data);

        return $data;
    }

    public static function getJsonConfigElement(string $keyToFind=null): string|int|bool|array|null {
        // Повертає значення елементу за заданим ключем
        self::checkJsonConfigFileExists();
        foreach (self::getJsonConfig() as $key => $value)
            if ($keyToFind !== null && $key === $keyToFind)
                return $value;

        return null; // Якщо в JSON файлі немає елементу по заданому ключу, то повертається null
    }

    public static function isElementJson(string $key): bool {
        // Перевіряє, чи існує елемент у JSON-файлі за заданим ключем
        self::checkJsonConfigFileExists();
        return array_key_exists($key, self::getJsonConfig());
    }

    /*
     * МЕТОДИ ДЛЯ ПЕРЕВІРКИ КОРЕКТНОСТІ РОБОТИ ОСНОВНИХ МЕТОДІВ
     */
    public static function checkJsonConfigFileExists(): void {
        // Перевірити, чи існує файл, до якого метод намагається отримати доступ
        if (!file_exists(self::CONFIG_PATH)) {
            // Створення JSON файлу, якщо він не існує
            // Використовується заданий в константу CONFIG_DEFAULT шаблон
            file_put_contents(self::CONFIG_PATH, json_encode(self::CONFIG_DEFAULT, JSON_PRETTY_PRINT));
        }
    }
}