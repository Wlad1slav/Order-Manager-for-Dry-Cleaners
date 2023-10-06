<?php
include('base/include.php');
$pageTitle = "Користувачі";

include('base/header.php');
include('base/sidebar.php');

const COLUMNS = ['username', 'rights'];
?>

<div>
    <!--Форма створення користувачів-->
    <form method="post" class="userForm">
        <h1>Корристувачі</h1>
        <h2>Форма створення</h2>
        <label>
            <input name="username" type="text" placeholder="Логін" required>
        </label>

        <label>
            <input name="password" type="password" placeholder="Пароль" required>
        </label>

        <label>
            <select name="rights" required>
                <?php
                $rights = require '../settings/rights_list.php';
                foreach ($rights as $right)
                    echo "<option value='" . $right->getId() ."'>" . $right->getSlug() . "</option>";
                ?>
            </select>
        </label>

        <input type="submit" value="Додати">

    </form>
</div>

<div>
    <!--ТАБЛИЦЯ КОРИСТУВАЧІВ-->
    <h2>Список</h2>
    <table>
        <thead>
            <tr class="firsts-row">
                <th>ID</th>
                <th>Username</th>
                <th>Рівень прав</th>
            </tr>
        </thead>
        <thead>
            <?php
            foreach(User::getAll() as $user) {
                echo '<tr>';

                $column = 0;
                foreach ($user as $value) {
                    if ($column != 2)
                        echo "<th>$value</th>";
                    $column++;
                }
                echo "<th><a href='edit/". $user['id'] . "'>Редагувати</a></th>";
                echo "<th><a class='red-text' href='delete/". $user['id'] . "'>X</a></th>";
                echo '</tr>';
            }
            ?>
        </thead>
    </table>
    
</div>

<?php include('base/footer.php'); ?>
