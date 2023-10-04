<?php

class Goods {
    private int $id; // Ідентифікатор продукту
    private string $name; // Назва продукту
    private float $price; // Ціна за 1 шт. продукту

    private Utils $utils;

    /**
     * @param int $id
     * @param string $name
     * @param float $price
     */
    public function __construct(int $id, string $name, float $price) {
        $this->utils = new Utils(); // додаткові утіліти

        $this->id = $id;
        $this->utils->validateName($name, 'Конструктор Goods'); // Utils. Викликає помилку, якщо довжина строки = 0
        $this->name = $name;
        $this->price = $this->utils->atLeastFloat($price, 0); // Utils
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
        $this->utils->validateName($name, "setName(string $name)"); // Utils. Викликає помилку, якщо довжина строки = 0
        $this->name = $name;
    }

    public function getPrice(): float {
        // Повертає ціну товару
        return $this->price;
    }
    public function setPrice(float $price): void {
        // Встановлює ціну товару
        $this->price = $this->utils->atLeastFloat($price, 0); // Utils
    }

}