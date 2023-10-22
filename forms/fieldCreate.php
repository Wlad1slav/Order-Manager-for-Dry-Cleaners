<?php
//session_start();
global $router;

require_once 'ProductAdditionalFields.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fieldName = $_POST['fieldName'] ?? null;
    $fieldType = $_POST['fieldType'] ?? null;
    $defaultFieldValue = $_POST['defaultFieldValue'] ?? null;
    $availableValues = $_POST['availableValues'] ?? null;
    $availableValues = explode(',', $availableValues);

    $newField = new ProductAdditionalFields();
    $newField->addField($fieldName, $fieldType, $defaultFieldValue, $availableValues);
    $newField->save();
}

$router->redirect('settingsPage');