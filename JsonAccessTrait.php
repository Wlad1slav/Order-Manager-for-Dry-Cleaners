<?php

trait JsonAccessTrait {
    // Трейт для роботи з JSON конфігами

    public static function getJsonConfig(): ?array {
        // Завантажує та повертає вміст JSON-файлу як масив
        self::checkJsonConfigFileExists();
        return json_decode(file_get_contents(self::CONFIG_PATH), true);
    }

    public static function getJsonConfig_jsonFormat(): string {
        // Завантажує та повертає вміст JSON-файлу як строку
        self::checkJsonConfigFileExists();
        return file_get_contents(self::CONFIG_PATH);
    }

    public static function setJsonConfig(array $data): void {
        // Записує масив у форматі JSON до файлу
        self::checkJsonConfigFileExists();
        file_put_contents(self::CONFIG_PATH, json_encode($data));
    }

    public static function deleteJsonConfigElement(array $path): array {
        // Видаляє елемент з JSON-файлу
        self::checkJsonConfigFileExists();  // Перевіряє, чи існує JSON-файл
        $data = self::getJsonConfig();      // Завантажує поточний конфіг

        // Ітерує по шляху до передостаннього елемента
        $temp = &$data;
        for ($i = 0; $i < count($path) - 1; $i++) {
            $key = $path[$i];
            if (!isset($temp[$key]))
                throw new InvalidArgumentException("deleteJsonConfigElement(path): Ключ '$key' не знайдено в конфігурації");
            $temp = &$temp[$key];
        }

        // Видаляє останній елемент шляху
        $lastKey = end($path);
        if (!isset($temp[$lastKey]))
            throw new InvalidArgumentException("deleteJsonConfigElement(path): Останній ключ '$lastKey' не знайдено в конфігурації");

        unset($temp[$lastKey]);

        // Зберігає змінений конфіг
        self::setJsonConfig($data);

        return $data;
    }


    public static function editJsonConfigElement(array $path, string|int|bool|array|null $value): array {
        // Додає або редагує елемент у JSON-файлі
        // Щоб додати - в кінці шляху написати новий ключ нового елементу (якщо записати існуючий ключ, то буде редагувати)
        self::checkJsonConfigFileExists();  // Перевіряє, чи існує JSON-файл
        $data = self::getJsonConfig();      // Завантажує поточний конфіг

        // Змінює значення за вказаним шляхом
        $temp = &$data;
        foreach ($path as $key)
            $temp = &$temp[$key];
        $temp = $value;

        // Зберігає змінений конфіг
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