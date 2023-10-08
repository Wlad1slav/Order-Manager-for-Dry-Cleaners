<?php
include('base/include.php');

$pageTitle = "Користувачі";
include('base/header.php');
include('base/sidebar.php');

const COLUMNS = ['username', 'rights'];

session_start();
?>

<div>
    <!--Форма створення користувачів-->
    <form action="../forms/userCreate.php" method="post" class="userForm">
        <h1><?php echo $pageTitle?></h1>
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
                /**
                 * @var $DIR
                 */
                $rights = require "$DIR/settings/rights_list.php";
                foreach ($rights as $right)
                    echo "<option value='" . $right->getId() ."'>" . $right->getSlug() . "</option>";
                ?>
            </select>
        </label>

        <input type="submit" value="Додати">

    </form>
</div>

<?php
if (isset($_SESSION['error'])) {
    echo "<div class='error-message'>";

    echo '<h3>ERROR</h3>';
    echo '<p>' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);

    echo '</div>';
}
?>

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
                echo "<th><a class='red-text' href='javascript:void(0);' onclick='confirmAndDelete(". $user['id'] . ")'>X</a></th>"; // Функція видалення користувача
                echo '</tr>';
            }
            ?>
        </thead>
    </table>
    
</div>

<script>

</script>

<?php include('base/footer.php'); ?>
