<h2>Квитанції</h2>

<?php
if (!isset($fieldsArray))
    $fieldsArray = new ProductAdditionalFields();

$invoiceSettings = Invoice::getJsonConfig();
?>

<div class="subsection" id="invoice-current-settings">
    <h3>Які параметри використовувати в квитанціях</h3>
    <?php include "invoiceParamsSettings.php"; ?>
</div>

<div class="subsection" id="invoice-amount">
    <h3>Кількість квитанцій</h3>
    <?php include "invoiceAmount.php"; ?>
</div>

<h3>Видимість полів в таблиці квитанції</h3>
<?php
if (count($fieldsArray->getFields()) > 0) {
    echo '<div class="subsection" id="invoice-additional-fields">';
    include "invoiceAdditionalFieldView.php";
    echo '</div>';
}
?>

<div class="subsection" id="invoice-standard-fields">
    <?php include "invoiceStandardFieldView.php"; ?>
</div>

<div class="subsection" id="invoice-image">
    <h3>Зображення в квитанції</h3>
    <?php include "invoiceImg.php"; ?>
</div>

<div class="subsection" id="invoice-additional-texts">
    <h3>Додатковий текст в квитанції</h3>
    <?php include "invoiceContent.php"; ?>
</div>
