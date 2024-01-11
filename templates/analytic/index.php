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


<h1 class="analytic">Аналітика</h1>

<div class="analytic">
    <?php include 'perDay.php'; ?> <!-- Аналітика за сьогодні -->

    <?php include 'perMonth.php'; ?> <!-- Аналітика за місяць -->

    <?php include 'charts.php'; ?> <!-- Графіки -->
</div>

<?php include("$DIR/templates/base/footer.php"); ?>
