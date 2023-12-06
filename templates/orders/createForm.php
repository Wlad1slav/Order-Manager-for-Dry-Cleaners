<?php
global $DIR;
global $router;

require_once 'Order.php';
require_once 'Product.php';
require_once 'Goods.php';
require_once 'User.php';
require_once 'ProductAdditionalFields.php';

$user = User::checkLogin();

$orderSettings = Order::getJsonConfig();

const REDIRECT = 'ordersTable';
const ERROR_TITLE = '<b>Помилка при створенні замовлення</b><br>';
define("PRODUCTS_NUM", $orderSettings['Number of products']);
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $productions = [];

    for ($i = 1; $i <= PRODUCTS_NUM; $i++) {

        // Отримання об'єкту продукту
        $goodName = $_POST["good-name-$i"];
        if ($goodName == null) break; // Перевіряє, чи пусте поле продукту. Якщо пусте, то це значить що це кінечний виріб.
        $good = Goods::get(null,$goodName);

        // Вирахування ціни за виріб
        echo $_POST["discount-$i"];
        $price = $_POST["price-$i"] - (($_POST["price-$i"] / 100) * intval($_POST["discount-$i"]));

        // Створення масиву даних з додаткових полів
        $additionalFields = new ProductAdditionalFields();
        $additionalFieldsQuantity = $additionalFields->countExistingFields();
        $params = [];
        for ($f = 1; $f <= $additionalFieldsQuantity; $f++) {
            $field = $additionalFields->getFields()[$f-1]['name'];  // По номеру поля знаходиться його назва
            $params[$field] = $_POST["additionalPropertie-$f-$i"];  // Збереження введених в додаткове поле даніх в масиві
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

    $customer = Customer::get(null, $_POST["customer-name"]);

    $order = new Order($customer, $user, $productions);
    $order->save();

    $router->redirect('orderInvoice', ['id'=>$order->getId()]);
}