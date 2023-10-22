<?php
global $DIR;
global $router;
require_once 'ProductAdditionalFields.php';

if (isset($_GET['index']))
    $fieldIndex = intval($_GET['index']);
else
    die("index поля не вказаний!");

$fields = new ProductAdditionalFields();
$fields->removeField($fieldIndex);
$fields->save();

$router->redirect('settingsPage');
