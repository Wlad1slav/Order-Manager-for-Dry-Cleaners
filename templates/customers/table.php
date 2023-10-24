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
        <tbody>
        <?php
        foreach(array_reverse(Customer::getAll()) as $customer) {
            echo '<tr>';

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
                "')\" href='#edit'>Редагувати</a></th>";

            echo "<th><a class='red-text' href='javascript:void(0);' onclick='confirmAndDelete(". $customer['id'] . ", \"customers\")'>X</a></th>"; // Функція видалення клієнта

            echo '</tr>';
        }
        ?>
        </tbody>
    </table>

</div>