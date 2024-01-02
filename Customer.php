<?php

require_once 'RepositoryTraits.php';
require_once 'Utils.php';
require_once 'Repository.php';
require_once 'PythonPhp.php';

class Customer {
    use RepositoryTraits;

    private int $id; // Ідентифікатор замовника
    private string $fullName; // Ім'я замовника
    private ?string $phoneNumber; // Номер телефону замовника
    private float $discount; // Знижка, що має замовник
    private ?string $advertisingCompany; // Рекламна кампанія, звідки клієнт дізнався о нас

    const COLUMNS = ['name', 'phone', 'discount', 'advertising_company'];
    const TABLE = 'customers'; // Назва таблиці, у якої зберігаються данні

    /**
     * @param string $fullName
     * @param string|null $phoneNumber
     * @param float $discount
     * @param string|null $advertisingCompany
     * @param int $id
     */
    public function __construct(string $fullName, ?string $phoneNumber, float $discount=0, ?string $advertisingCompany=null, int $id = -1) {
        $this->id = $id;
        if (strlen($fullName) == 0 || strlen($fullName) > 70)
            throw new InvalidArgumentException("Конструктор Customer: Очікується, що ім'я $fullName не буде пустим і буде містити меньш, ніж 70 символів.");
        $this->fullName = $fullName;
        if ($phoneNumber !== null && strlen($phoneNumber) > 70)
            throw new InvalidArgumentException("Конструктор Customer: Очікується, що номер телефону $phoneNumber буде містити меньш, ніж 70 символів.");
        $this->phoneNumber = $phoneNumber;
        if ($discount > 100)
            throw new InvalidArgumentException('Конструктор Customer: Знижка не може бути більше 99%.');
        $this->discount = Utils::atLeastFloat($discount, 0);
        $this->advertisingCompany = $advertisingCompany;

        $this->repository = new Repository(self::TABLE, self::COLUMNS);
    }

    public static function get(?int $id=null, ?string $name=null): Customer {
        // Повертає клієнта у вигляді об'єкту
        $repository = new Repository(self::TABLE, self::COLUMNS);

        if ($id !== null)
            $customerValues = $repository->getRow($id);
        elseif ($name !== null)
            $customerValues = $repository->getRow($name, 'name');


        return new Customer(
            $customerValues['name'],
            $customerValues['phone'],
            $customerValues['discount'],
            $customerValues['advertising_company'],
            $customerValues['id']
        );
    }

    public function getValues(): array {
        return [
            $this->fullName,                // full_name                varchar
            $this->phoneNumber,             // phone_number             varchar
            $this->discount,                // discount                 float
            $this->advertisingCompany,      // advertisingCompany       varchar
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

    public function getAdvertisingCompany(): string {
        // Повертає рекламну кампанію клієнта
        return $this->advertisingCompany;
    }

    public function setAdvertisingCompany(string $advertisingCompany): void {
        // Змінює рекламну кампанію клієнта
        $this->advertisingCompany = $advertisingCompany;
    }

    public static function create(): array {
        // маршрут customerCreate
        // Ѳункція створення клієнта

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $phone = $_POST["phone"];
            $discount = $_POST["discount"];
            $advertisingCompany = $_POST["advertisingCompany"];

            try {
                $customer = new Customer($name, $phone, $discount, $advertisingCompany);
                $customer->save();
            } catch (Exception $e) {
                $_SESSION['error'] = '<b>Помилка при створенні клієнта</b><br>' . $e->getMessage();
            }
        }

        return [
            'rout-name' => 'customersTable',
            'rout-params' => []
        ];
    }

    public static function edit(): array {
        // маршрут customerEdit
        // Форма редагування користувача

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST["id"];
            $name = $_POST["name"];
            $phone = $_POST["phone"];
            $discount = $_POST["discount"];
            $advertisingCompany = $_POST["advertisingCompany"];

            try {
                $customer = Customer::get($id);
                $customer->setFullName($name);
                $customer->setPhoneNumber($phone);
                $customer->setDiscount($discount);
                $customer->setAdvertisingCompany($advertisingCompany);
                $customer->update();
            } catch (Exception $e) {
                $_SESSION['error'] = '<b>Помилка при редагуванні клієнта</b><br>' . $e->getMessage();
            }
        }

        return [
            'rout-name' => 'customersTable',
            'rout-params' => [],
            'page-section' => "customer-$id"
        ];

    }

    public static function deleteMethod(): array {
        // маршрут customerDelete
        // Ѳункція видалення клієнта

        if (isset($_GET['id']))
            $customerID = intval($_GET['id']);
        else {
            // Немає id у URL. Обробка помилки.
            $_SESSION['error'] = '<b>Помилка при видаленні клієнта</b><br> Був невказаний id клієнта.';
            return [
                'rout-name' => 'customersTable',
                'rout-params' => [],
            ];
        }

        try {
            Customer::get($customerID)->delete();
        } catch (Exception $e) {
            $_SESSION['error'] = '<b>Помилка при видаленні клієнта</b><br>' . $e->getMessage();
        }

        return [
            'rout-name' => 'customersTable',
            'rout-params' => [],
        ];

    }

    public static function import(): array {
        // маршрут customersImport
        // Імпортує клієнтів з csv таблиці
        if ($_FILES["fileToUpload"]['size'] > 0) { // Якщо зображення завантаженно

            try {
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], 'scripts/orders_for_import.csv');

                $res = PythonPhp::script('customers_import.py', true);
                echo implode("<br>", $res['output']);

            } catch (InvalidArgumentException $e) {
                $_SESSION['error'] = "<b>Помилка при імпорті замовлень:</b><br> $e";
                echo $e;
                return [
                    'rout-name' => 'customersTable',
                    'rout-params' => []
                ];
            }
        }

        return [
            'rout-name' => 'customersTable',
            'rout-params' => [],
        ];
    }
}