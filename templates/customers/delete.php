<?php
global $DIR;
global $router;
require_once 'Customer.php';

CONST REDIRECT = 'customersTable';
CONST ERROR_TITLE = '<b>Помилка при видаленні клієнта</b><br>';

if (isset($_GET['id']))
    $customerID = intval($_GET['id']); // конвертуємо id в ціле число, щоб запобігти можливим атакам
else {
    // Немає id у URL. Обробка помилки.
    $_SESSION['error'] = ERROR_TITLE . 'Не був вказаний ID клієнта.';
    $router->redirect(REDIRECT);
}

try {
    Customer::get($customerID)->delete();
} catch (Exception $e) {
    $_SESSION['error'] = ERROR_TITLE . $e->getMessage();
}

$router->redirect(REDIRECT);
