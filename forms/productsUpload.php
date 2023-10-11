<?php
$target_dir = "../settings/"; // Каталог для збереження файлу.
$target_file = $target_dir . basename('goods.csv');

$fileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

if ($fileType != "csv") {// Перевірка, чи в форматі .csv файл
    die("<h1>Помилка при імпорті</h1><br> На жаль імпорт файлів з розширенням файлу $fileType недоступно. Будь ласка, переконайтесь, що файл у форматі <b><i>.csv</i></b>!");
}

try {
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
} catch (Exception $e) {
    die("<h1>Помилка при імпорті продуктів</h1><br>" . $e->getMessage());
}
?>

<script src="../static/javascript/utils.js"></script>
<script>
    redirectTo('/products');
</script>
