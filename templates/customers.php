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
        <div>
            <h2>Список</h2>
            <b> :: </b>
            <a href="#import" class="cta-text">Імпортувати</a>
            <b> :: </b>
            <a href="/settings/templates/customers_template.csv" class="cta-text">Шаблон для імпорту</a>
            <b> :: </b>
            <a onclick="convertAndDownloadTable('customers')" href="javascript:void(0);" class="cta-text">Експортувати</a>
            <b> :: </b>
        </div>
        <table id="customers">
            <thead>
            <tr>
                <th>ID</th>
                <th>Ім'я</th>
                <th>Номер телефону</th>
                <th>Знижка %</th>
                <th>Звідки дізнався о нас</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach(array_reverse(Customer::getAll()) as $customer) {
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
            </tbody>
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

<div>
    <form action="../forms/customersUpload.php" method="post" enctype="multipart/form-data" id="import">
        <h2>Імпорт клієнтів</h2>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Завантажити" name="submit">
    </form>
<!--    <h3>Обережно!</h3>-->
    <p><span class="warning">(!)</span> Після початку імпорту файлу не зачиняйте сторінку! Імпорт може зайняти деякий час.</p>
    <p><span class="warning">(!)</span> Якщо у вас винекне помилка <b>при іморті</b>, то вас перенаправить на іншу сторінку. В самому низу буде зазначено, в якому саме рядку сталася помилка.</p>
    <p><span class="warning">(!)</span> Рекомендуємо завантажувати не більше 1000 рядків за раз! Інакше винекне помилка, через перенавантаження скрипту.<br></p>
    <p>Ви можете вручну змінити налаштування у файлі <b>forms/customerUpload.php</b>. Визначте скільки секунд ви хочете, щоб обраблявся скрипт `set_time_limit(60)`.</p>
    <p><i>520 рядків = ~30 секунд.</i></p>
    <p><span class="warning">(!)</span> Не забувайте о лімітах:</p>
    <ul>
        <li>Ім'я клієнта не може пустим і перевищувати 70 символів</li>
        <li>Номер телефону клієнта не може перевищувати 20 символів</li>
        <li>Знижка клієнта не може бути пустою, меньше 0 і більше 99</li>
        <li>Клетинка зі знижкою клієнта може містити тільки числове значення</li>
    </ul>
    <p><i>Налаштувати ліміти ви можете у файлі <b>settings/config.php</b></i></p>
</div>

<?php include('base/footer.php'); ?>