<h3>Квитанції</h3>

<?php

if (!isset($fieldsArray))
    $fieldsArray = new ProductAdditionalFields();

if (count($fieldsArray->getFields()) > 0)
    include "invoiceAdditionalFieldView.php";
?>
