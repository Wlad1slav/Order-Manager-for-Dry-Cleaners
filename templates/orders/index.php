<?php
global $DIR;
global $router;
include("$DIR/templates/base/include.php");

$pageTitle = "Замовлення";
include("$DIR/templates/base/header.php");
include("$DIR/templates/base/sidebar.php");
?>

<div>

    <h1>Замовлення</h1>

    <b>::</b>
    <a href="<?php echo $router->url('orderCreate')?>" class="underline-animation" style="font-weight: 800">Нове замовлення</a>
    <b>::</b>
    <a href="<?php echo $router->url('ordersExport'); ?>" class="cta-text underline-animation">Експорт</a>
    <b>::</b>
    <a href="#import" class="cta-text underline-animation">Імпорт</a>
    <b>::</b>

    <?php // Обробчик помилок, що можуть виникнути при взаїмодії з замовленнями
    if (isset($_SESSION['error'])) {
        echo "<div class='error-message'>";

        echo '<h3>ERROR</h3>';
        echo '<p>' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);

        echo '</div>';
    }
    ?>

</div>

<?php include 'table.php' ?> <!-- Таблиця замовлень -->

<?php include 'import.php' ?> <!-- Таблиця замовлень -->

<?php include("$DIR/templates/base/footer.php"); ?>