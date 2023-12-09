<p>Які поля показувати у квитанції</p>

<script src="/static/javascript/edit.js"></script>
<?php
require_once 'Invoice.php';

$fields = Invoice::getJsonConfig()['Fields']['Standard']; // Стандартні поля

foreach ($fields as $field=>$info) {
    echo "<input type='checkbox' 
    onclick='switchFieldInvoiceStatus(\"$field\", \"Standard\")' 
    id='additional-field-invoice-status-$field'" . ($info['displayed'] === true ? 'checked' : '') . ">";

    echo "<label for='additional-field-invoice-status-$field'>{$info['localization']}</label>";
}
?>
