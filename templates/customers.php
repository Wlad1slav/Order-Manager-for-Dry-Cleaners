<?php
include('base/include.php');

$pageTitle = "Клієнти";
include('base/header.php');
include('base/sidebar.php');

session_start();
?>

<div>
    <!--Форма створення нових клієнтів-->
    <form action="../forms/customerCreate.php" method="post">
        <h1><?php echo $pageTitle?></h1>
        <h2>Форма створення</h2>

        <label>
            <input name="name" type="text" placeholder="Ім'я" required>
        </label>

        <label>
            <input name="phone" type="tel" placeholder="Номер телефону">
        </label>

        <label>
            <input name="discount" type="number" min="0" max="99" placeholder="Знижка" value="0" required>
        </label>

        <label>
            <input name="advertisingCompany" type="text" placeholder="Рекламна кампанія">
        </label>

        <input type="submit" value="Додати">

    </form>
</div>

<?php // Обробчик помилок, що можуть виникнути при створенні клієнта
if (isset($_SESSION['error'])) {
    echo "<div class='error-message'>";

    echo '<h3>ERROR</h3>';
    echo '<p>' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);

    echo '</div>';
}
?>

    <div>
        <!--ТАБЛИЦЯ КЛІЄНТІВ-->
        <h2>Список</h2>
        <table>
            <thead>
            <tr class="firsts-row">
                <th>ID</th>
                <th>Ім'я</th>
                <th>Номер телефону</th>
                <th>Знижка %</th>
                <th>Звідки дізнався о нас</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <thead>
            <?php
            foreach(Customer::getAll() as $customer) {
                echo '<tr>';

                $column = 0;
                foreach ($customer as $value) {
                    echo "<th>$value</th>";
                    $column++;
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
            </thead>
        </table>

    </div>
    <script src="../static/javascript/edit.js"></script>
    <div>
        <!--Форма редагування клієнтів-->
        <form action="../forms/customerEdit.php" method="post" id="edit">
            <h2>Форма редагування</h2>

            <label>
                <input name="id" id="id" type="number" min="0" placeholder="ID" required>
            </label>

            <label>
                <input name="name" id="name" type="text" placeholder="Ім'я" required>
            </label>

            <label>
                <input name="phone" id="phone" type="tel" placeholder="Номер телефону">
            </label>

            <label>
                <input name="discount" id="discount" type="number" min="0" max="99" placeholder="0%" required>
            </label>

            <label>
                <input name="advertisingCompany" id="advertising_company" type="text" placeholder="Рекламна кампанія">
            </label>

            <input type="submit" value="Змінити">

        </form>
    </div>

<?php include('base/footer.php'); ?>