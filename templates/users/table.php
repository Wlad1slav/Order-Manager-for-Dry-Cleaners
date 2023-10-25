<div>
    <!--ТАБЛИЦЯ КОРИСТУВАЧІВ-->
    <script>
        <!--Налаштування таблиці-->
        $(document).ready( function () {
            $('#users').DataTable({
                columnDefs: [
                    { width: '3%', targets: 0 },
                    { width: '10%', targets: 2 },
                    { width: '3%', targets: 3 },
                ],
            });
        });
    </script>

    <table id="users">
        <thead>
        <tr class="firsts-row">
            <th>ID</th>
            <th>Username</th>
            <th>Рівень прав</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach(User::getAll() as $user) {
            echo '<tr>';

            $column = 0;
            foreach ($user as $value) {
                if ($column != 2)
                    echo "<th>$value</th>";
                $column++;
            }
            echo "<th><a class='red-text' href='javascript:void(0);' onclick='confirmAndDelete(". $user['id'] . ", \"users\")'>X</a></th>"; // Функція видалення користувача
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>

</div>