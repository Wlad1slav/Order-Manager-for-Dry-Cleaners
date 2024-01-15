<?php
global $DIR;
global $router;

require_once 'User.php';

const REDIRECT = 'usersTable';
CONST ERROR_TITLE = '<b>Помилка при видаленні користувача</b><br>';

if (isset($_GET['id']))
    $userID = intval($_GET['id']); // конвертуємо id в ціле число, щоб запобігти можливим атакам
else {
    // Немає id у URL. Обробка помилки.
    $_SESSION['error'] = ERROR_TITLE . 'Не був вказаний ID користувача.';
    $router->redirect(REDIRECT);
}

$loginUserId = User::getLoginUser()->getId();
if ($userID === $loginUserId) {
    $_SESSION['error'] = ERROR_TITLE . "Неможна видалити самого себе.";
    $router->redirect(REDIRECT);
}

try {
    User::get($userID)->delete();
} catch (Exception $e) {
    $_SESSION['error'] = ERROR_TITLE . $e->getMessage();
}

$router->redirect(REDIRECT);


