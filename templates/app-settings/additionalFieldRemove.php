<?php
// Видалення додаткового поля для замовлень
require_once 'User.php';
User::checkLogin();

global $DIR;
global $router;
require_once 'ProductAdditionalFields.php';

CONST REDIRECT = 'settingsPage';
CONST ERROR_TITLE = '<b>Помилка при видаленні додаткового поля</b><br>';

if (isset($_GET['index']))
    $fieldIndex = intval($_GET['index']);
else {
    $_SESSION['error'] = ERROR_TITLE . 'Не був вказаний індекс додаткового поля.';
    $router->redirect(REDIRECT);
}

try {
    $fields = new ProductAdditionalFields();
    $fields->removeField($fieldIndex);
    $fields->save();
} catch (Exception $e) {
    $_SESSION['error'] = ERROR_TITLE . $e->getMessage();
}

$router->redirect(REDIRECT);
