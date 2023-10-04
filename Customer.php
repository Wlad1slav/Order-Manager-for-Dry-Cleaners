<?php

class Customer {
    private int $id; // Ідентифікатор замовника
    private string $fullName; // Ім'я замовника
    private string $phoneNumber; // Номер телефону замовника
    private float $discount; // Знижка, що має замовник

    private Utils $utils;

    /**
     * @param int $id
     * @param string $fullName
     * @param string $phoneNumber
     * @param float $discount
     */
    public function __construct(int $id, string $fullName, string $phoneNumber, float $discount) {
        $this->utils = new Utils(); // додаткові утіліти

        $this->id = $id;
        if (strlen($fullName) == 0)
            throw new InvalidArgumentException('Конструктор Customer: Очікується, що fullName не буде пустим.');
        $this->fullName = $fullName;
        if (strlen($phoneNumber) == 0)
            throw new InvalidArgumentException('Конструктор Customer: Очікується, що password не буде пустим.');
        $this->phoneNumber = $phoneNumber;
        $this->discount = $this->utils->atLeastFloat($discount, 0);
    }

    public function getId(): int {
        // Повертає Ідентифікатор клієнта
        return $this->id;
    }

    public function getFullName(): string {
        // Повертає ім'я клієнту
        return $this->fullName;
    }

    public function setFullName(string $fullName): void {
        // Встановлює ім'я клієнта
        if (strlen($fullName) == 0)
            throw new InvalidArgumentException('Конструктор Customer: Очікується, що fullName не буде пустим.');
        $this->fullName = $fullName;
    }

    public function getPhoneNumber(): string {
        // Повертає номер телефону клієнта
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): void {
        // Встановлює номер телефону клієнта
        $this->phoneNumber = $phoneNumber;
    }

    public function getDiscount(): float {
        // Повертає знижку клієнта
        return $this->discount;
    }

    public function setDiscount(float $discount): void {
        // Встановлює знижку клієнта
        $this->discount = $this->utils->atLeastFloat($discount, 0);
    }
}