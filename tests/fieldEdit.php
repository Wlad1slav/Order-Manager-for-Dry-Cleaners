<?php
require_once 'ProductAdditionalFields.php';
$additionalFields = new ProductAdditionalFields();

$additionalFields->editField('0', 'displayedOnInvoice', true);
$additionalFields->save();