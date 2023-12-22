<?php
global $DIR;
global $router;
include("$DIR\\templates\base\include.php");

$pageTitle = "Замовлення";
include("$DIR\\templates\base\header.php");
include("$DIR\\templates\base\sidebar.php");

const TABLE_COLUMNS = [
    // Колонки замовлення
    'id' => 'id',
    'id_customer' => 'Customer',
    'id_user' => 'User',
    'date_create' => 'Date',
    'date_end' => 'Data',
    'total_price' => 'Price',
    'is_paid' => 'Boolean',
    'is_completed' => 'Boolean'
];

?>

<div>

    <h1>Замовлення</h1>

    <b>::</b>
    <a href="<?php echo $router->url('orderCreate')?>" class="underline-animation" style="font-weight: 800">Нове замовлення</a>
    <b>::</b>
    <a onclick="convertAndDownloadTable('orders')" href="javascript:void(0);" class="cta-text underline-animation">Експорт</a>
    <b>::</b>
    <a href="#import" class="cta-text underline-animation">Імпорт</a>
    <b>::</b>

</div>

<?php include 'table.php' ?> <!-- Таблиця замовлень -->

<?php include 'import.php' ?> <!-- Таблиця замовлень -->

<?php include("$DIR\\templates\base\\footer.php"); ?>