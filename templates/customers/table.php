<?php
if (!isset($router))
    global $router;
?>

<div>
    <!--ТАБЛИЦЯ КЛІЄНТІВ-->
    <script>
        <!--Налаштування таблиці-->
        $(document).ready( function () {
            $('#customers').DataTable({
                columnDefs: [
                    { width: '3%', targets: 0 },
                    { width: '8%', targets: 3 },
                    { width: '8%', targets: 5 },
                    { width: '3%', targets: 6 }
                ],
            });
        });
    </script>

    <table id="customers">
        <thead>
        <tr>
            <th>ID</th>
            <th>Ім'я</th>
            <th>Номер телефону</th>
            <th>Знижка</th>
            <th>Звідки дізнався о нас</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <script>
            function confirmCustomerDelete(id) { // Ѳунція підтвердження видалення клієнта і відправки ajax запиту на сервер
                // Підтвердження видалення
                const isConfirmed = confirm("Ви впевненні, що хочете видалити клієнта з ID: " + id + "?");

                if (isConfirmed) {
                    // Якщо підтверджено, відбувається редірект до точки видалення з ідентифікатором об'єкту
                    $.ajax({
                        type: "GET",
                        url: "<?php echo $router->url('customerDelete'); ?>",
                        data: {id: id},
                    });
                    location.reload();
                }
            }
        </script>
        <tbody>
        <?php
        foreach(Customer::getAll() as $customer) {
            echo "<tr id='customer-{$customer['id']}'>";

            foreach ($customer as $value) {
                if ($value === "None") $value = '';
                echo "<th>$value</th>";
            }
            echo "<th><a onclick=\"editCustomer('" . // Функція редагування клієнта
                $customer['id'] . "','" .
                $customer['name'] . "','" .
                $customer['phone'] . "','" .
                $customer['discount'] . "','" .
                $customer['advertising_company'] .
                "')\" href='#edit' class='underline-animation'>Редагувати</a></th>";

            echo "<th><a class='red-text' href='javascript:void(0);' onclick='confirmCustomerDelete({$customer['id']})'>X</a></th>"; // Функція видалення клієнта

            echo '</tr>';
        }
        ?>
        </tbody>
    </table>

</div>