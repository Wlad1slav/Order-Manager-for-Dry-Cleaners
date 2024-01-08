<?php
require_once 'Analytic.php';
global $DIR;
include("$DIR/templates/base/include.php");

$date = $_GET['date'];
$pageTitle = "Замовлення за $date";
include("$DIR/templates/base/header.php");
include("$DIR/templates/base/sidebar.php");

global $router;

if (!isset($analytic))
    $analytic = new Analytic();

$orders = $analytic->getAllOrdersByDate($date, $_GET['field'])['orders'] ?? [];

echo "<h1>Замовлення {$_GET['status']} за $date</h1>";
?>

<script>
    function f() {
        // Проводить редірект на сторінку з іншим параметром date

        // Отримуємо поточний URL
        let currentUrl = window.location.href;

        // Встановлюємо нову дату, яку хочемо вставити
        let newDate = document.getElementById('date').value;

        // Замінюємо старий параметр дати новим
        let newUrl = currentUrl.replace(/(date=)[^&]+/, '$1' + newDate);

        // Змінюємо адресу в браузері на новий URL
        window.location.href = newUrl;
    }
</script>

<input onchange="f()" type="date" id="date" value="<?php echo $date; ?>">

<?php include "$DIR/templates/orders/table.php"; ?>
