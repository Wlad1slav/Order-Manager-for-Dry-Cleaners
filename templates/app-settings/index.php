<?php
global $DIR;
include("$DIR/templates/base/include.php");

$pageTitle = "Налаштування";
include("$DIR/templates/base/header.php");
include("$DIR/templates/base/sidebar.php");

global $router;
?>

<style>
    .content {
        background-image:
                /*url('static/images/background.jpg');*/
        url('static/images/background-2.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;

    }
</style>

<div class="settings">

<h1>Налаштування</h1>

    <div class="section">
        <?php include 'orders-settings.php'; ?> <!-- Налаштування замовлень -->
    </div>



</div>


<?php include("$DIR/templates/base/footer.php"); ?>