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
        foreach(array_reverse(Order::getAll()) as $order) {
            echo '<tr>';

            $orderID = $order['id'];

            foreach ($order as $key => $value) {
                foreach (TABLE_COLUMNS as $column => $type) {
                    if ($column == $key) {
                        if ($type === 'Customer')
                            echo '<th>' . Customer::get($value)->getFullName() . '</th>';
                        elseif ($type === 'User')
                            echo '<th>' . User::get($value)->getUsername() . '</th>';
                        elseif ($type === 'Boolean') {
                            echo '<th>';
                            echo "<input type='radio' onclick=\"switchOrderStatus('$column', true, $orderID)\" id='$key-$orderID-true' name='$key-$orderID' " . ($value === 1 ? 'checked' : '') . ">";
                            echo "<label for='$key-$orderID-true'>Так</label>";

                            echo "<input type='radio' onclick=\"switchOrderStatus('$column', false, $orderID)\" id='$key-$orderID-false' name='$key-$orderID' " . ($value === 0 ? 'checked' : '') . ">";
                            echo "<label for='$key-$orderID-false'>Ні</label>";
                            echo '</th>';
                        }
                        else
                            echo "<th>$value</th>";
                    }
                }
            }

            echo "<th><a href='{$router->url('orderInvoice', ['id'=>$orderID])}' 
                    class='underline-animation unimportant'>Квитанція</a></th>";

            echo "<th><a href='#' class='underline-animation unimportant'>Редагувати</a></th>";

            echo "<th><a class='red-text' href='javascript:void(0);' onclick='confirmOrderDelete($orderID)'>X</a></th>"; // Функція видалення клієнта

            echo '</tr>';
        }

        ?>
        </tbody>
    </table>

</div>