<?php
require_once 'User.php';
$user = User::get($_SESSION['user']['id']);

require_once "Order.php";
$orderID = intval($_GET['id']);
$order = Order::get($orderID);

$todayDate = new DateTime();

require_once 'ProductAdditionalFields.php';
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
                <b>ФОП Радіч Наталя Анатоліївна, ІПН 2996809966 <br>
                    Пральня-Хімчистка одягу "Єнот у Білому"</b></p>
            <p> <!-- Адреса -->
                Бучанський р-н, с.Білогородка, вул. Ярова 1а
            </p>
            <p> <!-- Підприємство -->
                Тел. (067) 454-00-26
            </p>
        </div>

        <img src="/static/images/invoice_image.png" alt="" class="logo">

    </div>

    <h1>Квитанція №<?php echo $order->getId() ?> від <?php echo $todayDate->format('Y-m-d') ?></h1>

    <p> <!-- Гарантія -->
        Найменування замовлення - чистка виробу згідно рекомендацій виробника, за відсутностю мітки з рекомендаціями щодо чищення виробу від виробника - виріб приймається тільки під відповідність клієнта без жодної гарантії щодо якості та товарно виду виробу після чищення.
        <br>
        Гарантійний термін 5 днів з дати отримання речі з хімчистки.
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
                    foreach (Invoice::getJsonConfigElement('Fields')['Standard'] as $fieldInfo)
                        if ($fieldInfo['displayed'])
                            echo "<th>{$fieldInfo['localization']}</th>";
                    ?>

                    <?php
                    // Вивід додаткових полів замовлення
                    // Отримання тільки тих додаткових полів, які відмічені маркером для показу в квитанції
                    $fields = new ProductAdditionalFields();
                    $fields = $fields->getInvoicePositiveFields();

                    // Вивод цих полів
                    foreach ($fields as $fieldKey=>$fieldInfo)
                        echo "<th>$fieldKey</th>";

                    ?>

                </tr>

                <?php
                $productNum = 0;
                foreach ($order->getProductions() as $product) {
                    echo '<tr>';
                    echo "<td>{$product->getGoods()->getName()}</td>";

                    $fieldStatus = Invoice::getJsonConfigElement('Fields')['Standard'];

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
                        if (Invoice::getJsonConfigElement('Fields')['Additional'][$additionalFieldName]['displayed'])
                            // Якщо видимість поля == true
                            echo "<td>$value</td>";

                    $productNum++;
                }

                ?>
            </table>

        </div>

        <p>Загальна вартість замовлення <?php echo $order->getTotalPrice(); ?> грн.</p>
        <p>З умовами типового договору по аквачистці, пранню виробів, вказаних в "Інформації для клієнта" ознайомленний і погоджуюся. З визначенням дефектів та оцінкою виробів погоджуюся.</p>

        <p>Менеджер <?php echo $user->getUsername()  ?></p>
    </div>

    <p>Замовник проводить попередню повну оплату послуг. Оплата послуг підтверджується фіскальним касовим чеком, який обов'язково додається до квітанції.</p>
    <p>Замовлення отримав "_____"______________20 ___ підпис____________________</p>

</div>

</body>
</html>
