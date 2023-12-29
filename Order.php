<?php

require_once 'RepositoryTraits.php';
require_once 'Repository.php';
require_once 'Customer.php';
require_once 'User.php';
require_once 'Product.php';
require_once 'Goods.php';
require_once 'JsonAccessTrait.php';
require_once 'ProductAdditionalFields.php';
require_once 'PythonPhp.php';
require_once 'Router.php';

class Order {
    use RepositoryTraits;   // Трейт для операцій класу з бд
    // Константи для роботи з базою даних
    const COLUMNS = ['id_customer', 'id_user', 'date_create', 'date_end', 'total_price', 'productions', 'is_paid', 'is_completed', 'date_payment', 'date_closing', 'date_last_update', 'settings'];
    const TABLE = 'orders'; // Назва таблиці, у якої зберігаються данні

    use JsonAccessTrait;    // Трейт для операцій з json файлами
    // Константи для роботи з конфігом
    const CONFIG_PATH = 'settings/config_orders.json'; // Шлях до конфігу
    const CONFIG_DEFAULT = [
        'Number of products' => 5,
        'Quick note selection' => []
    ];

    private int $id;                // Ідентифікатор замовлення. Встановлюється після збереження замовлення.
    private Customer $customer;     // Клієнт, що зробив замовлення
    private User $user;             // Сотрудник, що створив замовлення
    private DateTime $dateCreate;   // Дата створення замовлення
    private DateTime $dateEnd;      // Дедлайн замовлення
    private $datePayment;           // Дата оплати замовлення
    private $dateClosing;           // Дата закриття замовлення
    private $dateUpdate;            // Дата останього оновлення замовлення
    private bool $isPaid;           // Чи оплачено замовлення
    private bool $isCompleted;      // Чи виконано/закрите замовлення
    private float $totalPrice;      // Загальна ціна замовлення
    /** Очікується, що $productions буде зберігати масив об'єктів класу Product
     * @var Product[]
     */
    private array $productions=[];  // Масив виробів замовлення

    private string $settings;       // Налаштування замовлення

    /**
     * @param Customer $customer
     * @param User $user
     * @param Product[] $productions
     * @param int $id
     * @param bool $isPaid
     * @param bool $isCompleted
     * @param DateTime|null $dateCreate
     * @param null $datePayment
     * @param null $dateClosing
     * @param null $dateUpdate
     * @param string|null $settings
     */
    public function __construct(
        Customer $customer, User $user, array $productions,
        int $id = -1, bool $isPaid = false, bool $isCompleted = false,
        ?DateTime $dateCreate = null, // ?DateTime $dateEnd = null,
        $datePayment = null, $dateClosing = null, $dateUpdate = null,
        string $settings = null) {

        $this->id = $id;
        $this->customer = $customer;
        $this->user = $user;

        if ($dateCreate === null)
            $this->dateCreate = new DateTime();
        else $this->dateCreate = $dateCreate;
        $this->dateEnd = (clone $this->dateCreate)->modify('+3 day');

        $this->datePayment = $datePayment;
        $this->dateClosing = $dateClosing;
        $this->dateUpdate = $dateUpdate;

        $this->isPaid = $isPaid;
        $this->isCompleted = $isCompleted;

        $this->checkProductionsArray($productions, 'Конструктор Order');
        $this->productions = $productions;
        $this->totalPrice = $this->countTotalPrice();

        if ($settings === null)
            $this->settings = json_encode([
                'invoice_config' => Invoice::getJsonConfig_jsonFormat(),
                'additional_fields' => ProductAdditionalFields::getJsonConfig_jsonFormat(),
                'orders_config' => Order::getJsonConfig_jsonFormat()
            ], true);
        else $this->settings = $settings;

        $this->repository = new Repository(self::TABLE, self::COLUMNS);
    }

    public static function get(?int $id = null, ?string $name = null): Order {
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
            // DateTime::createFromFormat('Y-m-d', $orderValues['date_end']),
            $orderValues['date_payment'],
            $orderValues['date_closing'],
            $orderValues['date_last_update'],
            $orderValues['settings'],
        );
    }

    public function getValues(): array {
        return [
            $this->customer->getId(),                                           // id_customer      int
            $this->user->getId(),                                               // id_user          int
            $this->dateCreate,                                                  // date_create      datetime
            $this->dateEnd,                                                     // date_end         date
            $this->totalPrice,                                                  // total_price      float
            $this->convertProductionToJSON($this->productions),      // productions      json
            $this->isPaid,                                                      // is_paid          tinyint(1)
            $this->isCompleted,                                                 // is_completed     tinyint(1)
            $this->datePayment,                                                 // date_payment     date
            $this->dateClosing,                                                 // date_closing     date
            $this->dateUpdate,                                                  // date_last_update date
            $this->settings,                                                    // settings         json
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

    public function isCompleted(): bool {
        // Повертає t/f чи закрите замовлення
        return $this->isCompleted;
    }

    public function setIsPaid(bool $isPaid): void {
        // Встановлює t/f чи оплачено замовлення
        $this->isPaid = $isPaid;
        if ($isPaid)
            $this->datePayment = new DateTime();
        else $this->datePayment = null;
    }
    public function setIsCompleted(bool $isCompleted): void {
        // Встановлює t/f чи закрите замовлення
        $this->isCompleted = $isCompleted;
        if ($isCompleted)
            $this->dateClosing = new DateTime();
        else $this->dateClosing = null;
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
        return $result; // - ($result / 100 * $this->customer->getDiscount()); // Розрахування знижки на замовлення
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
        $this->totalPrice = $this->countTotalPrice();
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
                'discount' => $production->getDiscount(),       // Знижка за виріб
                'params' => $production->getParams(),           // Додаткові, кастомні параметри користувача
            ];
        }

        return json_encode($jsonData);
    }

    public function getSettings(): array {
        // Повертає налаштування квитанції замовлення у форматі масиву
        return json_decode($this->settings, true);
    }

    
    // Методи для виклику зовні, користувачем

    public static function savingQuickSelectionNotes_routeCall(): array {
        // notesFieldSave маршрут
        // Збереження швидкого вибору нотаток
        $orderSettings = self::getJsonConfig();
        $orderSettings["Quick note selection"] = explode(',', $_POST["notes-default"]);

        self::setJsonConfig($orderSettings);

        return [
            // Куди повинен повертатися користувач
            'rout-name' => 'settingsPage',
            'rout-params' => [],
            'page-section' => 'order-notes'
        ];
    }

    public static function savingProductAmount_routeCall(): array {
        // editProductsAmount маршрут
        // Збереження кількості виробів в замовлені
        $orderSettings = Order::getJsonConfig();
        $orderSettings["Number of products"] = $_POST["products-amount"];

        Order::setJsonConfig($orderSettings);

        return [
            'rout-name' => 'settingsPage',
            'rout-params' => [],
            'page-section' => 'order-products-amount'
        ];
    }

    public static function create(): array {
        // маршрут orderCreateForm
        $user = User::checkLogin();
        $orderSettings = Order::getJsonConfig();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $productions = self::getProductionFromForm($orderSettings);

            $customer = Customer::get(null, $_POST["customer-name"]);

            $order = new Order($customer, $user, $productions);
            $order->save();

            return [
                'rout-name' => 'orderInvoice',
                'rout-params' => ['id'=>$order->getId()]
            ];

        } else return [
            'rout-name' => 'ordersTable',
            'rout-params' => []
        ];
    }

    public static function edit(): array {
        // маршрут orderEditForm
        $orderID = $_GET['id'];
        $order = Order::get($orderID);
        $orderSettings = Order::getJsonConfig();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $productions = self::getProductionFromForm($orderSettings);

            $order->setProductions($productions);
            $order->update();

            return [
                'rout-name' => 'ordersTable',
                'rout-params' => [],
                'page-section' => "order-$orderID"
            ];

        } else return [
            'rout-name' => 'ordersTable',
            'rout-params' => []
        ];
    }

    private static function getProductionFromForm(array $orderSettings): array {
        // Метод, що повертає масив усіх виробів, отримуючи їх з форми

        $productions = [];

        for ($i = 1; $i <= $orderSettings['Number of products']; $i++) {

            // Отримання об'єкту продукту
            $goodName = $_POST["good-name-$i"];
            if ($goodName == null) break; // Перевіряє, чи пусте поле продукту. Якщо пусте, то це значить що це кінечний виріб.
            $good = Goods::get(null,$goodName);

            // Вирахування ціни за виріб
            $price = $_POST["price-$i"]; // - (($_POST["price-$i"] / 100) * intval($_POST["discount-$i"]));

            // Створення масиву даних з додаткових полів
            $additionalFields = new ProductAdditionalFields();
            $additionalFieldsQuantity = $additionalFields->countExistingFields();
            $params = [];

            $f = 1;
            foreach ($additionalFields->getFields() as $fieldName=>$fieldInfo) {
                $params[$fieldName] = $_POST["additionalPropertie-$f-$i"];
                $f++;
            }

            if (isset($_POST["notes-$i"])) {
                // Переведення масиву приміток в строку
                $mainNotes = implode(', ', $_POST["notes-$i"]);
                if (isset($_POST["notes-textarea-$i"])) $mainNotes .= ', '; // Якщо є додаткові примітки, то додається кома після основних
            }
            else
                $mainNotes = '';

            // Додавання до основних приміток додаткових
            $notes = $mainNotes . $_POST["notes-textarea-$i"];

            $productions[] = new Product(
                $_POST["amount-$i"],
                $notes,
                $params,
                $good,
                intval($_POST["discount-$i"]),
                $price
            );
        }

        return $productions;
    }

    public static function deleteMethod(): array {
        // Метод видалення замовлення
        $order = self::get($_GET['id']);
        $order->delete();

        return [
            'rout-name' => 'ordersTable',
            'rout-params' => []
        ];
    }

    public static function switchStatus(): array {
        // Маршрут switchOrderStatus
        // Метод видалення замовлення
        $newStatus = $_GET['newStatus'];
        $orderID = $_GET['orderID'];
        $column = $_GET['column'];

        if ($newStatus === 'true')
            $newStatus = true;
        elseif ($newStatus === 'false')
            $newStatus = false;

        $order = Order::get($orderID);

        if ($column == 'is_paid')
            $order->setIsPaid($newStatus);
        elseif ($column == 'is_completed')
            $order->setIsCompleted($newStatus);

//        echo 'isPaid = ' . $order->isPaid();
//        echo 'isCompleted = ' . $order->isCompleted();
        $order->update();

        return [
            'rout-name' => null,
            'rout-params' => []
        ];
    }

    public static function import(): array {
        // Маршрут ordersImport
        // Імпортує замовлення з csv таблиці
        if ($_FILES["orders-import"]['size'] > 0) { // Якщо зображення завантаженно

            try {
                move_uploaded_file($_FILES["orders-import"]["tmp_name"], 'scripts/orders_for_import.csv');

                $res = PythonPhp::script('orders_import.py', true);
                echo implode("<br>", $res['output']);

            } catch (InvalidArgumentException $e) {
                $_SESSION['error'] = "<b>Помилка при імпорті замовлень:</b><br> $e";
                echo $e;
                return [
                    'rout-name' => 'ordersTable',
                    'rout-params' => []
                ];
            }
        }

        return [
            'rout-name' => 'ordersTable',
            'rout-params' => [],
            'page-section' => 'import'
        ];
    }

    public static function export(): array {
        // Маршрут ordersExport
        // Експортує замовлення в csv таблицю

        try {
            $res = PythonPhp::script('orders_export.py', true);
            echo implode("<br>", $res['output']);
            Router::redirectUrl('/scripts/orders_exported.csv');
        } catch (InvalidArgumentException $e) {
            $_SESSION['error'] = "<b>Помилка при імпорті замовлень:</b><br> $e";
            echo $e;
            return [
                'rout-name' => 'ordersTable',
                'rout-params' => []
            ];
        }

        return [
            'rout-name' => 'ordersTable',
            'rout-params' => [],
            'page-section' => 'import'
        ];
    }


}