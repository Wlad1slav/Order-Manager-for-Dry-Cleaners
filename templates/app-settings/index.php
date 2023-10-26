<?php
global $DIR;
include("$DIR/templates/base/include.php");

$pageTitle = "Налаштування";
include("$DIR/templates/base/header.php");
include("$DIR/templates/base/sidebar.php");

global $router;
?>

<h1>Налаштування</h1>

<?php include 'additionalFieldTable.php'; ?> <!-- Таблиця додаткових полів замовлення -->

<?php include 'additionalFieldCreate.php'; ?> <!-- Форма створення нового поля замовлення -->


<?php include("$DIR/templates/base/footer.php"); ?>