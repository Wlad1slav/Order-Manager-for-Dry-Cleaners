<?php
$orderSettings = Order::getJsonConfig();
?>

<h2>Замовлення</h2>

<div class="subsection" id="order-products-amount">
    <?php include 'productsAmount.php'; ?> <!-- Встановлення кількості виробів в замовленні -->
</div>

<div class="subsection" id="order-deadline">
    <?php include 'orderDeadline.php'; ?> <!-- Встановлення довжини дедлаjну замовлення -->
</div>

<div class="subsection" id="additional-fields">
    <?php include 'additionalField.php'; ?> <!-- Налаштування додаткових полів замовлень -->
</div>

<div class="subsection" id="order-notes">
    <?php include 'notesField.php'; ?> <!-- Шаблон нотаток -->
</div>