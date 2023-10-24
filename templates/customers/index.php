<?php
global $DIR;
include("$DIR/templates/base/include.php");

$pageTitle = "Клієнти";
include("$DIR/templates/base/header.php");
include("$DIR/templates/base/sidebar.php");
?>

<h1><?php echo $pageTitle?></h1>

<?php include 'create.html' ?> <!-- Форма створення клієнта -->

<?php // Обробчик помилок, що можуть виникнути при взаїмодії з клієнтами
if (isset($_SESSION['error'])) {
    echo "<div class='error-message'>";

    echo '<h3>ERROR</h3>';
    echo '<p>' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);

    echo '</div>';
}
?>

<?php include 'table.php' ?> <!-- Таблиця клієнтів -->

<?php include 'edit.php' ?> <!-- Форма редагування клієнта -->

<?php include 'import.php' ?> <!-- Форма імпорту таблиці клієнтів -->

<?php include("$DIR/templates/base/footer.php"); ?>