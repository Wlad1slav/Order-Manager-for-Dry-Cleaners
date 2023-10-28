<?php
// Форма створення додаткового поля для замовлень
require_once 'User.php';
User::checkLogin();

global $router;

require_once 'ProductAdditionalFields.php';

CONST REDIRECT = 'settingsPage';
CONST ERROR_TITLE = '<b>Помилка при створенні додаткового поля</b><br>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fieldName = $_POST['fieldName'] ?? null;
    $fieldType = $_POST['fieldType'] ?? null;
    $defaultFieldValue = $_POST['defaultFieldValue'] ?? null;
    $availableValues = $_POST['availableValues'] ?? null;
    $availableValues = explode(',', $availableValues);

    try {
        $newField = new ProductAdditionalFields();
        $newField->addField($fieldName, $fieldType, $defaultFieldValue, $availableValues);
        $newField->save();
    } catch (Exception $e) {
        $_SESSION['error'] = ERROR_TITLE . $e->getMessage();
    }
}

$router->redirect('settingsPage');