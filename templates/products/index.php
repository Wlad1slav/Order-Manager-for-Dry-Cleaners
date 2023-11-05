<?php
global $DIR;
include("$DIR/templates/base/include.php");

$pageTitle = "Сервіси";
include("$DIR/templates/base/header.php");
include("$DIR/templates/base/sidebar.php");
?>

<h1>Сервіси, що надаються</h1>
<p>
    <b>::</b> <!-- Завантажити таблицю, що зараз використвується -->
    <a href="/settings/goods.csv" class="cta-text underline-animation">Існуюча таблиця</a>
    <b>::</b> <!-- Завантажити шаблон для імпорту продуктів -->
    <a href="/settings/templates/goods_template.csv" class="cta-text underline-animation">Завантажити шаблон для імпорту</a>
    <b>::</b>
</p>

<?php include 'import.html' ?>

<?php // Обробчик помилок, що можуть виникнути при створенні клієнта
if (isset($_SESSION['error'])) {
    echo "<div class='error-message'>";

    echo '<h3>ERROR</h3>';
    echo '<p>' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);

    echo '</div>';
}
?>

<?php include 'table.php' ?> <!-- Таблиця продуктів -->

<?php include("$DIR/templates/base/footer.php"); ?>