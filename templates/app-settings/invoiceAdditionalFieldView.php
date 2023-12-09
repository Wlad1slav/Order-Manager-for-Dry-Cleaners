<p>Які додаткові поля показувати у квитанції</p>

<script src="/static/javascript/edit.js"></script>
<?php
require_once 'Invoice.php';

if (!isset($fieldsArray))
    $fieldsArray = new ProductAdditionalFields();

$fieldIndex = 0;

foreach ($fieldsArray->getFields() as $key=>$field) {
    echo "<input type='checkbox' onclick='switchFieldInvoiceStatus(\"{$field['name']}\", \"Additional\")' 
    id='additional-field-invoice-status-$fieldIndex'" .
        (Invoice::getJsonConfigElement('Fields')['Additional'][$field['name']]['displayed'] === true ? 'checked' : '') . ">";

    echo "<label for='additional-field-invoice-status-$fieldIndex'>{$field['name']}</label>";
    $fieldIndex++;
}
?>
