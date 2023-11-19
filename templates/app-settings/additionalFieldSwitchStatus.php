<?php

require_once 'User.php';
User::checkLogin();

require_once 'ProductAdditionalFields.php';

$fieldIndex = $_GET['fieldIndex'];

$field = new ProductAdditionalFields();

$field->editField(strval($fieldIndex), 'displayedOnInvoice', !$field->getFields()[$fieldIndex]['displayedOnInvoice']);
$field->save();