<h2>Квитанції</h2>

<?php
if (!isset($fieldsArray))
    $fieldsArray = new ProductAdditionalFields();
?>

<div class="subsection">
    <?php
    if (count($fieldsArray->getFields()) > 0)
        include "invoiceAdditionalFieldView.php";
    ?>
</div>

<div class="subsection">
    <?php include "invoiceStandardFieldView.php"; ?>
</div>
