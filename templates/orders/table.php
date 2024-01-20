<?php
global $router;
?>

<div>
    <!--ТАБЛИЦЯ Замовлень-->
    <script>
        <!--Налаштування таблиці-->
        $(document).ready( function () {
            $('#orders').DataTable({
                columnDefs: [
                    { width: '2%', targets: 0 },
                    { width: '3%', targets: 6 },
                    { width: '4%', targets: 9 },
                    { width: '4%', targets: 10 },
                    { width: '1%', targets: 11 },
                ],
            });
        });
    </script>

    <table id="orders">
        <thead>
        <tr>
            <th>ID</th>
            <th>Дата створення</th>
            <th>Дедлайн</th>
            <th>Клієнт</th>
            <th>Рекламна кампанія</th>
            <th>Хто створив?</th>
            <th>Ціна</th>
            <th>Чи оплачено?</th>
            <th>Чи закрито?</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        <script src="/static/javascript/edit.js"></script>
        <script>
            function confirmOrderDelete(id) {
                // Підтвердження видалення
                const isConfirmed = confirm("Ви впевненні, що хочете видалити замовлення з ID: " + id + "?");

                if (isConfirmed) {
                    // Якщо підтверджено, відбувається редірект до точки видалення з ідентифікатором об'єкту
                    $.ajax({
                        type: "GET",
                        url: "<?php echo $router->url('orderDelete'); ?>",
                        data: {id: id},
                    });
                    location.reload();
                }
            }

            function switchOrderStatus(column, newStatus, orderID) {
                // Змінює статус замовлення
                $.ajax({
                    type: "GET",
                    url: "<?php echo $router->url('switchOrderStatus'); ?>",
                    data: {column: column, newStatus: newStatus, orderID: orderID},
                });

                if (!newStatus) // Встановлення видимості селектору типу оплати (картка - готівка)
                    document.getElementById(`select-payment-type-${orderID}`).classList.add('invisible');
                else document.getElementById(`select-payment-type-${orderID}`).classList.remove("invisible");

            }

            function switchOrderStatusOpenClose(column, newStatus, orderID) {
                // Змінює статус замовлення
                $.ajax({
                    type: "GET",
                    url: "<?php echo $router->url('switchOrderStatus'); ?>",
                    data: {column: column, newStatus: newStatus, orderID: orderID},
                });
            }

            function selectPaymentType(type, orderID) {
                // Змінює статус замовлення
                $.ajax({
                    type: "GET",
                    url: "<?php echo $router->url('selectPaymentType'); ?>",
                    data: {type: type, orderID: orderID},
                });

                if (type === 'cash') {
                    document.getElementById(`cash-button-${orderID}`).classList.add('selected-type');
                    document.getElementById(`card-button-${orderID}`).classList.remove('selected-type');
                } else {
                    document.getElementById(`card-button-${orderID}`).classList.add('selected-type');
                    document.getElementById(`cash-button-${orderID}`).classList.remove('selected-type');
                }
            }
        </script>

        <?php

        if (!isset($orders))
            $orders = Order::getAll();
        $customers = Customer::getAll('id'); // id - ключ, по якому будуть доступни елементи масиву
        $users = User::getAll('id');

        $tableBody = '';
        $statuses = ['is_paid', 'is_completed'];

        foreach($orders as $order) {

            $orderID = $order['id'];

            $tableRow = "<tr id='order-$orderID'>";

            $tableRow .= "<th>$orderID</th>";                                                   // ID
            $tableRow .= "<th>{$order['date_create']}</th>";                                    // Дата і час створення
            $tableRow .= "<th>{$order['date_end']}</th>";                                       // Дата дедлайну

            if (isset($customers[$order['id_customer']]['name']))                               // Ім'я клієнта
                $tableRow .= "<th>{$customers[$order['id_customer']]['name']}</th>";
            else $tableRow .= '<th><i>видалений</i></th>';

            if (isset($customers[$order['id_customer']]['advertising_company']))                // Рекламна кампанія, звідки клієнт
                $tableRow .= "<th>{$customers[$order['id_customer']]['advertising_company']}</th>";
            else $tableRow .= '<th></th>';

            $tableRow .= "<th>{$users[$order['id_user']]['username']}</th>";                    // Юзернейм користувача
            $tableRow .= "<th>{$order['total_price']} ₴</th>";                                  // Ціна

            // Переключення статусу замовлення
            foreach ($statuses as $status) {
                $tableRow .= '<th>';
                $tableRow .= "<input type='radio' onclick=\"switchOrderStatus('$status', true, $orderID)\" id='$status-$orderID-true' name='$status-$orderID-true' " . ($order[$status] === 1 ? 'checked' : '') . ">";
                $tableRow .= "<label for='$status-$orderID-true'>Так</label>";

                $tableRow .= "<input type='radio' onclick=\"switchOrderStatusOpenClose('$status', false, $orderID)\" id='$status-$orderID-false' name='$status-$orderID-true' " . ($order[$status] === 0 ? 'checked' : '') . ">";
                $tableRow .= "<label for='$status-$orderID-false'>Ні</label>";

                if ($status === 'is_paid') {
                    if ($order[$status]) // $status = 'is_paid'; // and $order['type_of_payment'] === null
                        $tableRow .= "<div id='select-payment-type-$orderID'>"; // Невидимий елемент
                    else $tableRow .= "<div id='select-payment-type-$orderID' class='invisible'>"; // Невидимий елемент



                    $tableRow .= "<button onclick='selectPaymentType(\"cash\", $orderID)' id='cash-button-$orderID'"
                        . ($order['type_of_payment'] === 'cash' ? 'class="selected-type"' : '')
                        . ">Готівка</button>";

                    $tableRow .= "<button onclick='selectPaymentType(\"card\", $orderID)' id='card-button-$orderID'"
                        . ($order['type_of_payment'] === 'card' ? 'class="selected-type"' : '')
                        . ">Картка</button>";

                    $tableRow .= '</div>';
                }

                $tableRow .= '</th>';
            }

            $tableRow .= "<th><a href='{$router->url('orderInvoice', ['id'=>$orderID])}'
                    class='underline-animation unimportant'>Квитанція</a></th>";

            $tableRow .= "<th><a href='{$router->url('orderEdit', ['id'=>$orderID])}' class='underline-animation unimportant'>Редагувати</a></th>";

            $tableRow .= "<th><a class='red-text' href='javascript:void(0);' onclick='confirmOrderDelete($orderID)'>X</a></th>"; // Функція видалення клієнта

            $tableRow .= '</tr>';

            $tableBody .= $tableRow;
        }

        echo $tableBody;

        ?>
        </tbody>
    </table>

</div>