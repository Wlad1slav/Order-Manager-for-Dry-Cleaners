<?php
include('base/include.php');

$pageTitle = "Замовлення";
include('base/header.php');
include('base/sidebar.php');

const TABLE_COLUMNS = [
    'id' => 'id',
    'id_customer' => 'Customer',
    'id_user' => 'User',
    'date_create' => 'Date',
    'date_end' => 'Data',
    'total_price' => 'Price',
    'is_paid' => 'Boolean',
    'is_completed' => 'Boolean'
];

?>

<div>

    <h1>Замовлення</h1>

    <b>::</b>
    <a href="orders/new" style="font-weight: 800">Нове замовлення</a>
    <b>::</b>
    <a onclick="convertAndDownloadTable('orders')" href="javascript:void(0);" class="cta-text">Експорт</a>
    <b>::</b>
    <a href="#import" class="cta-text">Імпорт</a>
    <b>::</b>

</div>

<div>
    <!--ТАБЛИЦЯ Замовлень-->
    <script>
        <!--Налаштування таблиці-->
        $(document).ready( function () {
            $('#orders').DataTable({
                columnDefs: [
                    { width: '3%', targets: 0 },
                    { width: '8%', targets: 8 },
                    { width: '3%', targets: 9 },
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
        </tr>
        </thead>
        <tbody>

        <script src="../static/javascript/edit.js"></script>
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
                            echo "<input type='radio' onclick=\"switchStatus('$column', true, $orderID)\" id='$key-$orderID-true' name='$key-$orderID' " . ($value === 1 ? 'checked' : '') . ">";
                            echo "<label for='$key-$orderID-true'>Так</label>";

                            echo "<input type='radio' onclick=\"switchStatus('$column', false, $orderID)\" id='$key-$orderID-false' name='$key-$orderID' " . ($value === 0 ? 'checked' : '') . ">";
                            echo "<label for='$key-$orderID-false'>Ні</label>";
                            echo '</th>';
                        }
                        else
                            echo "<th>$value</th>";
                    }
                }
            }
            echo "<th><a href='#'>Редагувати</a></th>";

            echo "<th><a class='red-text' href='javascript:void(0);' onclick='confirmAndDelete(". $order['id'] . ", \"order\")'>X</a></th>"; // Функція видалення клієнта

            echo '</tr>';
        }

        ?>
        </tbody>
    </table>

</div>

<?php include('base/footer.php'); ?>
