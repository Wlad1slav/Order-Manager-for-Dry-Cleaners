<?php

class Goods {
    private int $id; // Ідентифікатор продукту
    private string $name; // Назва продукту
    private float $price; // Ціна за 1 шт. продукту

    const GOODS_LIST_DIR = 'settings/goods.csv';

    /**
     * @param int $id
     * @param string $name
     * @param float $price
     */
    public function __construct(int $id, string $name, float $price) {
        $this->id = $id;
        Utils::validateName($name, 'Конструктор Goods'); // Utils. Викликає помилку, якщо довжина строки = 0
        $this->name = $name;
        $this->price = Utils::atLeastFloat($price, 0); // Utils
    }

    public static function get(int $id): Goods {
        // Повертає об'єкт продукту виробу
        $file = fopen(self::GOODS_LIST_DIR, 'r'); // Файл з усіма продуктами

        if (!$file) // Перевіряє, чи існує файл з продуктами
            die("Не вдалося відкрити файл " . self::GOODS_LIST_DIR);

        // Читайте дані з файлу рядок за рядком
        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            // $data тепер масив з даними з поточного рядка
            if ($data[0] == $id) {
                $goods = new Goods($data[0], $data[1], $data[2]);
                fclose($file); // Закриває файл
                return $goods;
            }
        }
        fclose($file); // Закриває файл
        throw new InvalidArgumentException("Goods get(int $id): Продукту з id $id не знайдено.");
    }

    public static function getAll(): array {
        // Повертає масив з інформацією про продукти виробів
        $file = fopen(self::GOODS_LIST_DIR, 'r'); // Файл з усіма продуктами

        if (!$file) // Перевіряє, чи існує файл з продуктами
            die("Не вдалося відкрити файл " . self::GOODS_LIST_DIR);

        $products = [];
        while (($data = fgetcsv($file, 1000, ",")) !== FALSE)
            // Читайте дані з файлу рядок за рядком
            $products[] = $data;
        fclose($file);

        return $products;
    }

    public function getId(): int {
        // Повертає Ідентифікатор товару
        return $this->id;
    }

    public function getName(): string {
        // Повертає ім'я
        return $this->name;
    }
    public function setName(string $name): void {
        // Встановлює назву товару
        Utils::validateName($name, "setName(string $name)"); // Utils. Викликає помилку, якщо довжина строки = 0
        $this->name = $name;
    }

    public function getPrice(): float {
        // Повертає ціну товару
        return $this->price;
    }
    public function setPrice(float $price): void {
        // Встановлює ціну товару
        $this->price = Utils::atLeastFloat($price, 0); // Utils
    }

}