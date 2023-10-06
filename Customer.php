<?php

class Customer {
    use RepositoryTraits;

    private int $id; // Ідентифікатор замовника
    private string $fullName; // Ім'я замовника
    private string $phoneNumber; // Номер телефону замовника
    private float $discount; // Знижка, що має замовник

    const COLUMNS = ['full_name', 'phone_number', 'discount'];
    const TABLE = 'customers'; // Назва таблиці, у якої зберігаються данні

    /**
     * @param int $id
     * @param string $fullName
     * @param string $phoneNumber
     * @param float $discount
     */
    public function __construct(string $fullName, string $phoneNumber, float $discount, int $id = -1) {
        $this->id = $id;
        if (strlen($fullName) == 0 || strlen($fullName) > 30)
            throw new InvalidArgumentException('Конструктор Customer: Очікується, що fullName не буде пустим і буде містити меньш, ніж 30 символів.');
        $this->fullName = $fullName;
        if (strlen($phoneNumber) == 0 || strlen($phoneNumber) > 20)
            throw new InvalidArgumentException('Конструктор Customer: Очікується, що password не буде пустим і буде містити меньш, ніж 20 символів.');
        $this->phoneNumber = $phoneNumber;
        if ($discount > 100)
            throw new InvalidArgumentException('Конструктор Customer: Знижка не може бути більше 99%.');
        $this->discount = Utils::atLeastFloat($discount, 0);

        $this->repository = new Repository(self::TABLE, self::COLUMNS);
    }

    public static function get(int $id): Customer {
        // Повертає клієнта у вигляді об'єкту
        $repository = new Repository(self::TABLE, self::COLUMNS);
        $customerValues = $repository->getRow($id);
        return new Customer(
            $customerValues['full_name'],
            $customerValues['phone_number'],
            $customerValues['discount'],
            $customerValues['id']
        );
    }

    public function getValues(): array {
        return [
            $this->fullName,        // full_name        varchar
            $this->phoneNumber,     // phone_number     varchar
            $this->discount         // discount         float
        ];
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
        if ($discount > 100)
            throw new InvalidArgumentException("setDiscount(float $discount): Знижка не може бути більше 99%.");
        $this->discount = Utils::atLeastFloat($discount, 0);
    }
}