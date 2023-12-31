<?php
require_once 'User.php';
User::checkLogin();

global $router;

$target_dir = "settings/"; // Каталог для збереження файлу.

// Перевірка існування директорії, якщо немає - створення
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true); // true - рекурсивне створення
}

$target_file = $target_dir . basename('goods.csv');

$fileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

if ($fileType != "csv") {// Перевірка, чи в форматі .csv файл
//    die("<h1>Помилка при імпорті</h1><br> На жаль імпорт файлів з розширенням файлу $fileType недоступно. Будь ласка, переконайтесь, що файл у форматі <b><i>.csv</i></b>!");
    $_SESSION['error'] = "<b>Помилка при імпорті продуктів.</b><br>Формат повинен буте .csv, ви намагалися імпортувати файл із розширенням $fileType!";
    $router->redirect('productsList');
}

try {
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
} catch (Exception $e) {
//    die("<h1>Помилка при імпорті продуктів</h1><br>" . $e->getMessage());
    $_SESSION['error'] = '<b>Помилка при імпорті продуктів</b><br>' . $e->getMessage();
    $router->redirect('productsList');
}

$router->redirect('productsList');

