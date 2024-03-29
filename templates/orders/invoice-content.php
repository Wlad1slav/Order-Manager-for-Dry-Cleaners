<div class="invoice">

    <div class="heading">

        <div class="info">
            <p> <!-- Назва підприємства -->
                <b><?php echo $invoiceSettings['Text']['Information']['Business'] ?></b>
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

        <!-- Вивід лого бізнесу -->
        <?php
        $logo = Invoice::getJsonConfigElement('Image');
        if ($logo['displayed'])
            echo "<img src='{$logo['path']}' alt='' class='logo'>"
        ?>


    </div>

    <h1>Квитанція №<?php echo $order->getId() ?> від <?php echo $todayDate->format('Y-m-d') ?></h1>

    <p class="additional-text"> <!-- Гарантія -->
        <?php echo $invoiceSettings['Text']['Start'] ?>
    </p>

    <div class="invoice-info">  <!-- Основна інформація о замовленні -->
        <div class="customer-info">     <!-- Інформація о замовнике -->
            <p>
                <b>Замовник:</b> <?php echo $order->getCustomer()->getFullName() ?>
            </p>
            <?php // Якщо у користувача є номер телефону
            $phone = $order->getCustomer()->getPhoneNumber();
            if (strlen($phone > 0) and $phone !== null)
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
                        if ($invoiceSettings['Fields']['Additional'][$additionalFieldName]['displayed']) {
                            // Якщо видимість поля == true
                            if (is_array($value)) {
                                // Якщо значення додаткового поля - масив (checkbox), то виводяться усі його елементи
                                echo '<td>';
                                foreach ($value as $el)
                                    echo "$el. ";
                                echo '</td>';
                            }
                            else echo "<td>$value</td>";
                        }

                    $productNum++;
                }

                ?>
            </table>

        </div>

        <p>Загальна вартість замовлення <?php echo $order->getTotalPrice(); ?> грн.</p>

        <p class="additional-text"><?php echo $invoiceSettings['Text']['End'] ?></p>

        <p>Менеджер <?php echo $user->getUsername()  ?></p>
    </div>

    <p class="additional-text">Замовник проводить попередню повну оплату послуг. Оплата послуг підтверджується фіскальним касовим чеком, який обов'язково додається до квітанції.</p>
    <p>Замовлення отримав "_____"______________20 ___ підпис____________________</p>

</div>