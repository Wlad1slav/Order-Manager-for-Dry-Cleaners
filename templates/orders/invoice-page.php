<?php
require_once 'User.php';
require_once 'ProductAdditionalFields.php';
require_once "Order.php";

$user = User::get($_SESSION['user']['id']);

$orderID = intval($_GET['id']);
$order = Order::get($orderID);

// Ініціалізація конфігів
$additionalFields = new ProductAdditionalFields();
if (Invoice::getJsonConfigElement('Current')) {
    // Якщо прийнято використовувати актуальні налаштування
    $invoiceSettings = Invoice::getJsonConfig(); // Ініціалізація у якості конфігу квитанцій вмісту config_invoice.json
    $additionalFields = $additionalFields->getInvoicePositiveFields($invoiceSettings); // Ініціалізація у якості масиву додаткових полів вмісту config_additional_fields.json
}  else {
    // Якщо прийнято використовувати актуальні тільки на момент створення замовлення
    $params = $order->getSettings();
    $invoiceSettings = json_decode($params['invoice_config'], true); // Ініціалізація у якості конфігу квитанцій елемент invoice_config масиву налаштувань замовленя, що зберігається в бд
    $fields = json_decode($params['additional_fields'], true);
    $additionalFields = $additionalFields->getInvoicePositiveFields($invoiceSettings, $fields);
}

$todayDate = new DateTime();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Квитанція №<?php echo $order->getId() ?></title>
    <link rel="stylesheet" href="/static/css/invoice.css">
    <link rel="stylesheet" href="/static/css/root.css">
</head>
<body>

<div class="invoices">
<?php
for ($i = 1; $i <= $invoiceSettings['Amount']; $i++)
    include 'invoice-content.php';

?>
</div>

</body>
</html>
