<?php

class Order {
    private int $id; // Ідентифікатор замовлення
    private Customer $customer; // Клієнт, що зробив замовлення
    private User $user; // Сотрудник, що створив замовлення
    private DateTime $dateCreate; // Дата створення замовлення
    private DateTime $dateEnd; // Дедлайн замовлення
    private bool $isPaid; // Чи оплачено замовлення
    private bool $isCompleted; // Чи виконано/закрите замовлення
    private float $totalPrice; // Загальна ціна замовлення
    /** Очікується, що $productions буде зберігати масив об'єктів класу Product
     * @var Product[]
     */
    private array $productions = []; // Масив виробів замовлення

    /**
     * @param int $id
     * @param Customer $customer
     * @param User $user
     * @param Product[] $productions
     */
    public function __construct(int $id, Customer $customer, User $user, array $productions) {
        $this->id = $id;
        $this->customer = $customer;
        $this->user = $user;
        $this->dateCreate = new DateTime();
        $this->dateEnd = (clone $this->dateCreate)->modify('+3 day');
        $this->isPaid = false;
        $this->isCompleted = false;
        $this->checkProductionsArray($productions, 'Конструктор Order');
        $this->productions = $productions;
        $this->totalPrice = $this->countTotalPrice();
    }


    public function getId(): int {
        // Повертає Ідентифікатор замовлення
        return $this->id;
    }

    public function getCustomer(): Customer {
        // Повертає об'єкт клієнту
        return $this->customer;
    }
    public function setCustomer(Customer $customer): void {
        // Встановлює об'єкт клієнту
        $this->customer = $customer;
    }

    public function getUser(): User {
        // Повертає об'єкт користувача, що створив замовлення
        return $this->user;
    }
    public function setUser(User $user): void {
        // Встановлює об'єкт користувача, що створив замовлення
        $this->user = $user;
    }

    public function getDateCreate(): DateTime {
        // Повертає дату створення замовлення
        return $this->dateCreate;
    }

    public function getDateEnd(): DateTime {
        // Повертає дату дедлайну замовлення
        return $this->dateEnd;
    }
    public function setDateEnd(DateTime $dateEnd): void {
        // Встановлює дату дедлайну замовлення
        $this->dateEnd = $dateEnd;
    }

    public function isPaid(): bool {
        // Повертає t/f чи оплачено замовлення
        return $this->isPaid;
    }
    public function setIsPaid(bool $isPaid): void {
        // Встановлює t/f чи оплачено замовлення
        $this->isPaid = $isPaid;
    }
    public function switchPaidStatus(): void {
        // Переключає статус t/f чи оплачено замовлення
        $this->isPaid = !$this->isPaid;
    }

    public function isCompleted(): bool {
        // Повертає t/f чи закрите замовлення
        return $this->isCompleted;
    }
    public function setIsCompleted(bool $isCompleted): void {
        // Встановлює t/f чи закрите замовлення
        $this->isCompleted = $isCompleted;
    }
    public function switchCompleteStatus(): void {
        // Переключає статус t/f чи закрите замовлення
        $this->isCompleted = !$this->isCompleted;
    }

    public function getTotalPrice(): float {
        // Повертає повну ціну за замовлення
        return $this->totalPrice;
    }
    public function setTotalPrice(float $totalPrice): void {
        // Встановлює повну ціну за замовлення
        $this->totalPrice = $totalPrice;
    }
    public function countTotalPrice(): float {
        // Рахує і повертає повну ціну за замовлення
        $result = 0;
        foreach ($this->productions as $product)
            $result += $product->getPrice();
        return $result - ($result / 100 * $this->customer->getDiscount()); // Розрахування знижки на замовлення
    }

    /**
     * @return Product[]
     */
    public function getProductions(): array {
        // Повертає масив усіх виробів
        return $this->productions;
    }
    /**
     * @param Product[] $productions
     */
    public function setProductions(array $productions): void {
        // Встановлює масив усіх виробів
        $this->checkProductionsArray($productions, 'setProductions(array $productions)');
        $this->productions = $productions;
    }
    /**
     * @param Product[] $productions
     */
    public function checkProductionsArray(array $productions, string $errorPlace = 'checkProductionsArray()'): bool {
        // Перевірка, чи усі елементи масиву виробів належать класу Product
        foreach ($productions as $product) // Проходиться по усім елементам масиву,
            if (!$product instanceof Product) // щоб перевірити, чи усі є об'єктами класу Product
                throw new InvalidArgumentException("$errorPlace: Очікується масив об’єктів класу Product");
        return true;
    }

    /**
     * @param Product $product
     */
    public function addProduct(Product $product): void {
        // Додає новий виріб у масив виробів
        $this->productions[] += $product;
        $this->totalPrice = $this->countTotalPrice();
    }
    /**
     * @param Product $product
     */
    public function removeProduct(Product $product): void {
        // Видаляє заданий виріб
        $key = array_search($product, $this->productions);
        if ($key !== false) {
            unset($this->productions[$key]);
            $this->totalPrice = $this->countTotalPrice();
        }
    }

    public function getComponents() : array {
        // Надає словник з подробной інформацією о замовлені
        $num = 0;
        $components = [];
        foreach ($this->productions as $production) {
            $num++;
            $params = [
                'Товар' => $production->getGoods()->getName(),
                'Кількість' => $production->getAmount(),
                'Ціна' => $production->getPrice() . ' UAH (' . $production->getGoods()->getPrice() . ' UAH за штуку)',
                'Нотатки' => $production->getNote()
            ];

            $components[$num] = $params;
        }

        return $components;
    }

}