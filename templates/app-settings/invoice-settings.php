<h2>Квитанції</h2>

<?php
if (!isset($fieldsArray))
    $fieldsArray = new ProductAdditionalFields();
?>

<div class="subsection">
    <h3>Кількість квитанцій</h3>
    <?php include "invoiceAmount.php"; ?>
</div>

<h3>Видимість полів в таблиці квитанції</h3>
<?php
if (count($fieldsArray->getFields()) > 0) {
    echo '<div class="subsection">';
    include "invoiceAdditionalFieldView.php";
    echo '</div>';
}
?>

<div class="subsection">
    <?php include "invoiceStandardFieldView.php"; ?>
</div>

<div class="subsection">
    <h3>Зображення в квитанції</h3>
    <?php include "invoiceImg.php"; ?>
</div>

<div class="subsection">
    <h3>Додатковий текст в квитанції</h3>
    <?php include "invoiceContent.php"; ?>
</div>
