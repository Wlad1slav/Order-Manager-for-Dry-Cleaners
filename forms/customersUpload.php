<?php // Імпорт таблиці клієнтів у базу даних
set_time_limit(70); // Скільки секунд може викониватися скрипт

$target_dir = "uploads/"; // Каталог для збереження файлу.
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

// Перевірка наявності файлу
if (isset($_POST["submit"])) {
    // Отримання інформації о файлі
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // // Перевірка розміру файлу (немає потреби)
    // if ($_FILES["fileToUpload"]["size"] > 500000) // приблизно 500KB
    //     $_SESSION['error'] = '<b>Помилка при імпорті клієнтів</b><br>: Файл занадто великий';

    if ($fileType != "csv") {// Перевірка, чи в форматі .csv файл
        die("<h1>Помилка при імпорті клієнтів</h1><br> На жаль імпорт файлів з розширенням файлу $fileType недоступно. Будь ласка, переконайтесь, що файл у форматі <b><i>.csv</i></b>!");
    }

    try {
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    } catch (Exception $e) {
        die("<h1>Помилка при імпорті клієнтів</h1><br>" . $e->getMessage());
    }

    $file = fopen($target_file, 'r'); // $target_file = uploads/example.csv

    require_once '../Customer.php';
    $num = 1;
    while (($data = fgetcsv($file, 1500, ",")) !== FALSE) {
        // Читайте дані з файлу рядок за рядком
        echo $num . '. ' . $data[0] . '<br>';
        $num++;

        $customer = new Customer($data[0], $data[1], $data[2], $data[3]);
        $customer->save();
    }

    fclose($file); // Закриває файл
}

?>

<script src="../static/javascript/utils.js"></script>
<script>
    redirectTo('/customers');
</script>
