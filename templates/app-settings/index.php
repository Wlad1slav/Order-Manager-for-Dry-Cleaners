<?php
global $DIR;
include("$DIR/templates/base/include.php");

$pageTitle = "Налаштування";
include("$DIR/templates/base/header.php");
include("$DIR/templates/base/sidebar.php");

global $router;


?>

<link rel="stylesheet" href="../../static/css/settings.css">

<style>
    .content {
        background-image:
                /*url('static/images/background.jpg');*/
        url('static/images/background-2.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;

    }

    html {
        scroll-behavior: auto;
    }
</style>

<div class="settings">

<h1>Налаштування</h1>

    <?php
    if (isset($_SESSION['error'])) {
        echo "<div class='error-message'>";

        echo '<h3>ERROR</h3>';
        echo '<p>' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);

        echo '</div>';
    }
    ?>

    <div class="section" id="order">
        <?php include 'orders-settings.php'; ?> <!-- Налаштування замовлень -->
    </div>

    <div class="section" id="invoice">
        <?php include 'invoice-settings.php'; ?> <!-- Налаштування квитанцій -->
    </div>



</div>


<?php include("$DIR/templates/base/footer.php"); ?>