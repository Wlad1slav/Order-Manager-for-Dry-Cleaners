<?php

require_once 'RepositoryTraits.php';
require_once 'Repository.php';
require_once 'Customer.php';
require_once 'User.php';
require_once 'Product.php';
require_once 'Goods.php';

class Order {
    use RepositoryTraits; // Черта для операцій класу з бд

    private int $id;                // Ідентифікатор замовлення. Встановлюється після збереження замовлення.
    private Customer $customer;     // Клієнт, що зробив замовлення
    private User $user;             // Сотрудник, що створив замовлення
    private DateTime $dateCreate;   // Дата створення замовлення
    private DateTime $dateEnd;      // Дедлайн замовлення
    private bool $isPaid;           // Чи оплачено замовлення
    private bool $isCompleted;      // Чи виконано/закрите замовлення
    private float $totalPrice;      // Загальна ціна замовлення
    /** Очікується, що $productions буде зберігати масив об'єктів класу Product
     * @var Product[]
     */
    private array $productions = []; // Масив виробів замовлення

    const COLUMNS = ['id_customer', 'id_user', 'date_create', 'date_end', 'total_price', 'productions', 'is_paid', 'is_completed'];
    const TABLE = 'orders'; // Назва таблиці, у якої зберігаються данні

    /**
     * @param Customer $customer
     * @param User $user
     * @param Product[] $productions
     * @param int $id
     * @param bool $isPaid
     * @param bool $isCompleted
     * @param DateTime|null $dateCreate
     * @param DateTime|null $dateEnd
     * @throws Exception
     */
    public function __construct(
        Customer $customer, User $user,
        array $productions, int $id = -1,
        bool $isPaid = false, bool $isCompleted = false,
        ?DateTime $dateCreate = null, ?DateTime $dateEnd = null) {

        $this->id = $id;
        $this->customer = $customer;
        $this->user = $user;

//        $date = new DateTime('now', new DateTimeZone('UTC'));
//        $date->setTimezone(new DateTimeZone('Europe/Kiev'));

        if ($dateCreate === null)
            $this->dateCreate = new DateTime();
        else $this->dateCreate = $dateCreate;
        if ($dateEnd === null)
            $this->dateEnd = (clone $this->dateCreate)->modify('+3 day');
        else $this->dateEnd = $dateEnd;

        $this->isPaid = $isPaid;
        $this->isCompleted = $isCompleted;

        $this->checkProductionsArray($productions, 'Конструктор Order');
        $this->productions = $productions;
        $this->totalPrice = $this->countTotalPrice();

        $this->repository = new Repository(self::TABLE, self::COLUMNS);
    }

    public static function get($id): Order {
        // Повертає замовлення у вигляді об'єкту
        $repository = new Repository(self::TABLE, self::COLUMNS);
        $orderValues = $repository->getRow($id);
        return new Order(
            Customer::get($orderValues['id_customer']),
            User::get($orderValues['id_user']),
            Product::pullFromDB($orderValues['id']),
            $orderValues['id'],
            $orderValues['is_paid'],
            $orderValues['is_completed'],
            DateTime::createFromFormat('Y-m-d H:i:s', $orderValues['date_create']),
            DateTime::createFromFormat('Y-m-d', $orderValues['date_end']),
        );
    }

    public function getValues(): array {
        return [
            $this->customer->getId(),                                           // id_customer      int
            $this->user->getId(),                                               // id_user          int
            $this->dateCreate,                                                  // date_create      datetime
            $this->dateEnd,                                                     // date_end         date
            $this->totalPrice,                                                  // total_price      float
            $this->convertProductionToJSON($this->productions),       // productions      json
            $this->isPaid,                                                      // is_paid          tinyint(1)
            $this->isCompleted                                                  // is_completed     tinyint(1)
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
        $jsonData = ['productions' => []];

        foreach ($productions as $production) {
            $jsonData['productions'][] = [
                'goodID' => $production->getGoods()->getId(),   // ID товару, сервісу
                'amount' => $production->getAmount(),           // Кількісь товару
                'price' => $production->getPrice(),             // Загальна ціна за виріб
                'note' => $production->getNote(),               // Нотатки
                'params' => $production->getParams()            // Додаткові, кастомні параметри користувача
            ];
        }

        return json_encode($jsonData);
    }

    public function getComponents(): array {
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