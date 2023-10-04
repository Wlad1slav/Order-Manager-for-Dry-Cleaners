<?php

class Order {
    private int $id; // Ідентифікатор замовлення. Встановлюється після збереження замовлення.
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

    private Repository $repository; // Доступ до бази даних

    const COLUMNS = ['id_customer', 'id_user', 'date_create', 'date_end', 'total_price', 'productions', 'is_paid', 'is_completed'];

    /**
     * @param Customer $customer
     * @param User $user
     * @param Product[] $productions
     */
    public function __construct(Customer $customer, User $user, array $productions) {
        $this->id = -1;
        $this->customer = $customer;
        $this->user = $user;
        $this->dateCreate = new DateTime();
        $this->dateEnd = (clone $this->dateCreate)->modify('+3 day');
        $this->isPaid = false;
        $this->isCompleted = false;
        $this->checkProductionsArray($productions, 'Конструктор Order');
        $this->productions = $productions;
        $this->totalPrice = $this->countTotalPrice();

        $this->repository = new Repository('orders');
    }

    public function save(): void {
        // Зберігає замовлення у базі даних
        $this->id = $this->repository->addRow($this::COLUMNS, $this->getValues());
    }

    public function update(): void {
        // Оновлює замовлення у базі даних
        $this->repository->updateRow($this->id, $this::COLUMNS, $this->getValues());
    }

    public function delete(): void {
        // Видаляє замовлення
        $this->repository->removeRow($this->id);
    }

    public function getAll(): array {
        // Повертає масив усіх замовлень
        return $this->repository->getAll();
    }

    public function getValues(): array {
        return [
            $this->customer->getId(),                               // id_customer      int
            $this->user->getId(),                                   // id_user          int
            $this->dateCreate,                                      // date_create      datetime
            $this->dateEnd,                                         // date_end         date
            $this->totalPrice,                                      // total_price      float
            $this->convertProductionToJSON($this->productions),     // productions      json
            $this->isPaid,                                          // is_paid          tinyint(1)
            $this->isCompleted                                      // is_completed     tinyint(1)
        ];
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
    private function convertProductionToJSON(array $productions): string {
        // Конвертує масив об'єктів класу Product у JSON формат
        /*
         {
             "productions": [
                 {
                     "goodID": 1,
                     "amount": 10,
                     "price": 720,
                     "note": "біле"
                 },
                 {
                     "goodID": 4,
                     "amount": 1,
                     "price": 40,
                     "note": ""
                 }
             ]
         }
        {"productions":[{"goodID":1,"amount":10,"price":170,"note":"\u0431\u0456\u043b\u0435"},{"goodID":2,"amount":2,"price":70,"note":"\u0413\u0430\u043b\u0438\u0447\u0438\u043d\u0430"},{"goodID":1,"amount":1,"price":17,"note":"\u0436\u043e\u0432\u0442\u0435"}]}
         */
        $jsonData = ['productions' => []];

        foreach ($productions as $production) {
            $jsonData['productions'][] = [
                'goodID' => $production->getGoods()->getId(),
                'amount' => $production->getAmount(),
                'price' => $production->getPrice(),
                'note' => $production->getNote(),
            ];
        }

        return json_encode($jsonData);
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