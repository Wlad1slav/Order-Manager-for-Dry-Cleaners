<p>Які додаткові поля показувати у квитанції</p>

<script src="/static/javascript/edit.js"></script>
<?php
require_once 'Invoice.php';

if (!isset($fieldsArray))
    $fieldsArray = new ProductAdditionalFields();
if (!isset($invoiceSettings))
    $invoiceSettings = Invoice::getJsonConfig();

$fieldIndex = 0;

foreach ($fieldsArray->getFields() as $key=>$field) {
    // $key - назва полю, $field - масив інформації про поле
    echo "<input type='checkbox' onclick='switchFieldInvoiceStatus(\"$key\", \"Additional\")' 
    id='additional-field-invoice-status-$fieldIndex'" .
        ($invoiceSettings['Fields']['Additional'][$key]['displayed'] === true ? 'checked' : '') . ">";

    echo "<label for='additional-field-invoice-status-$fieldIndex'>$key</label>";
    $fieldIndex++;
}
?>
