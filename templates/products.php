<?php
session_start();

include('base/include.php');

$pageTitle = "Сервіси";
include('base/header.php');
include('base/sidebar.php');
?>

<h1>Сервіси, що надаються</h1>
<p>
    <b>::</b>
    <a href="/settings/goods.csv" class="cta-text">Існуюча таблиця</a>
    <b>::</b>
    <a href="/settings/templates/goods_template.csv" class="cta-text">Завантажити шаблон для імпорту</a>
    <b>::</b>
</p>

    <!--ФОРМА ЗАВАНТАЖЕННЯ ТАБЛИЦІ ПРОДУКТІВ-->
    <form action="../forms/productsUpload.php" method="post" enctype="multipart/form-data" id="import">
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Завантажити" name="submit">
    </form>

<?php // Обробчик помилок, що можуть виникнути при створенні клієнта
if (isset($_SESSION['error'])) {
    echo "<div class='error-message'>";

    echo '<h3>ERROR</h3>';
    echo '<p>' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);

    echo '</div>';
}
?>

    <!--ТАБЛИЦЯ ПРОДУКЦІЇ-->
    <table id="products">
        <thead>
        <tr>
            <th>ID</th>
            <th>Назва</th>
            <th>Ціна</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach(array_reverse(Goods::getAll()) as $products) {
            echo '<tr>';

            foreach ($products as $value)
                echo "<th>$value</th>";

            echo '</tr>';
        }
        ?>
        </tbody>
    </table>



<?php include('base/footer.php'); ?>