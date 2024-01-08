<?php
global $DIR;
include("$DIR/templates/base/include.php");

$pageTitle = "Аналітика";
include("$DIR/templates/base/header.php");
include("$DIR/templates/base/sidebar.php");

global $router;

$analytic = new Analytic();
$orders = $analytic->get();
?>

<h1>Аналітика</h1>

<div style="display: flex;">
    <?php include 'perDay.php'; ?> <!-- Аналітика за сьогодні -->

    <?php include 'perMonth.php'; ?> <!-- Аналітика за місяць -->
</div>

<?php include("$DIR/templates/base/footer.php"); ?>
