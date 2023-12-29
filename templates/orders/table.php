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
                    { width: '3%', targets: 0 },
                    { width: '4%', targets: 8 },
                    { width: '4%', targets: 9 },
                    { width: '3%', targets: 10 },
                ],
            });
        });
    </script>

    <table id="orders">
        <thead>
        <tr>
            <th>ID</th>
            <th>Клієнт</th>
            <th>Був створений</th>
            <th>Дата створення</th>
            <th>Дедлайн</th>
            <th>Ціна</th>
            <th>Чи оплачений?</th>
            <th>Чи виконаний?</th>
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
            }
        </script>

        <?php

        $orders = Order::getAll();
        $customers = Customer::getAll('id'); // id - ключ, по якому будуть доступни елементи масиву
        $users = User::getAll('id');

        $tableBody = '';
        $statuses = ['is_paid', 'is_completed'];

        foreach($orders as $order) {

            $orderID = $order['id'];

            $tableRow = "<tr id='order-$orderID'>";

            $tableRow .= "<th>$orderID</th>";                                       // ID
            $tableRow .= "<th>{$order['date_create']}</th>";                        // Дата і час створення
            $tableRow .= "<th>{$order['date_end']}</th>";                           // Дата дедлайну
            $tableRow .= "<th>{$customers[$order['id_customer']]['name']}</th>";    // Ім'я клієнта
            $tableRow .= "<th>{$users[$order['id_user']]['username']}</th>";        // Юзернейм користувача
            $tableRow .= "<th>{$order['total_price']}₴</th>";                       // Ціна

            // Переключення статусу замовлення
            foreach ($statuses as $status) {
                $tableRow .= '<th>';
                $tableRow .= "<input type='radio' onclick=\"switchOrderStatus('$status', true, $orderID)\" id='$status-$orderID-true' name='$status-$orderID-true' " . ($order[$status] === 1 ? 'checked' : '') . ">";
                $tableRow .= "<label for='$status-$orderID-true'>Так</label>";

                $tableRow .= "<input type='radio' onclick=\"switchOrderStatus('$status', false, $orderID)\" id='$status-$orderID-false' name='$status-$orderID-true' " . ($order[$status] === 0 ? 'checked' : '') . ">";
                $tableRow .= "<label for='$status-$orderID-false'>Ні</label>";
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