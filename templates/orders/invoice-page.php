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

<div class="invoice">
    
    <div class="heading">

        <div class="info">
            <p> <!-- Назва підприємства -->
                <b><?php echo $invoiceSettings['Text']['Information']['Business'] ?></p>
            <p> <!-- Адреса -->
                <?php echo $invoiceSettings['Text']['Information']['Address'] ?>
            </p>
            <p> <!-- Номер телефону -->
                <?php echo $invoiceSettings['Text']['Information']['Phone'] ?>
            </p>
            <p> <!-- Пошта -->
                <?php echo $invoiceSettings['Text']['Information']['Email'] ?>
            </p>
        </div>

        <img src="/static/images/invoice_image.png" alt="" class="logo">

    </div>

    <h1>Квитанція №<?php echo $order->getId() ?> від <?php echo $todayDate->format('Y-m-d') ?></h1>

    <p> <!-- Гарантія -->
        <?php echo $invoiceSettings['Text']['Start'] ?>
    </p>

    <div class="invoice-info">  <!-- Основна інформація о замовленні -->
        <div class="customer-info">     <!-- Інформація о замовнике -->
            <p>
                <b>Замовник:</b> <?php echo $order->getCustomer()->getFullName() ?>
            </p>
            <?php // Якщо у користувача є номер телефону
            if (strlen($order->getCustomer()->getPhoneNumber()) > 0)
                echo "<p>
                    <b>Телефон:</b> {$order->getCustomer()->getPhoneNumber()} 
                </p>";
            ?>
        </div>

        <div class="order-info"> <!-- Інформація о замовленні -->

            <table>
                <tr>
                    <th>Найменування виробу</th>

                    <?php
                    // Вивід стандартних полів замовлення
                    foreach ($invoiceSettings['Fields']['Standard'] as $fieldInfo)
                        if ($fieldInfo['displayed'])
                            echo "<th>{$fieldInfo['localization']}</th>";
                    ?>

                    <?php
                    // Вивід додаткових полів замовлення
                    // Отримання тільки тих додаткових полів, які відмічені маркером для показу в квитанції
//                    $fields = new ProductAdditionalFields();
//                    $fields = $fields->getInvoicePositiveFields($invoiceSettings);

                    // Вивод цих полів
                    foreach ($additionalFields as $fieldKey=>$fieldInfo)
                        echo "<th>$fieldKey</th>";

                    ?>

                </tr>

                <?php
                $productNum = 0;
                foreach ($order->getProductions() as $product) {
                    echo '<tr>';
                    echo "<td>{$product->getGoods()->getName()}</td>";

                    $fieldStatus = $invoiceSettings['Fields']['Standard'];

                    if ($fieldStatus['amount']['displayed'])
                        echo "<td>{$product->getAmount()}</td>";
                    if ($fieldStatus['price']['displayed'])
                        echo "<td>{$product->getPrice()}</td>";
                    if ($fieldStatus['discount']['displayed'])
                        echo "<td>{$product->getDiscount()}</td>";
                    if ($fieldStatus['note']['displayed'])
                        echo "<td>{$product->getNote()}</td>";

                    // Виведення даних для полів, що відміченні маркером в налаштуваннях
                    foreach ($order->getProductions()[$productNum]->getParams() as $additionalFieldName=>$value)
                        // Об'єкт замовлення->Елемент по номеру виробу в масиві об'єктів Product->Масив параметрів виробу
                        if ($invoiceSettings['Fields']['Additional'][$additionalFieldName]['displayed'])
                            // Якщо видимість поля == true
                            echo "<td>$value</td>";

                    $productNum++;
                }

                ?>
            </table>

        </div>

        <p>Загальна вартість замовлення <?php echo $order->getTotalPrice(); ?> грн.</p>

        <?php echo $invoiceSettings['Text']['End'] ?>

        <p>Менеджер <?php echo $user->getUsername()  ?></p>
    </div>

    <p>Замовник проводить попередню повну оплату послуг. Оплата послуг підтверджується фіскальним касовим чеком, який обов'язково додається до квітанції.</p>
    <p>Замовлення отримав "_____"______________20 ___ підпис____________________</p>

</div>

</body>
</html>
