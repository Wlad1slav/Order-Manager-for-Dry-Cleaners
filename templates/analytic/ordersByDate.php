<?php
require_once 'Analytic.php';
global $DIR;
include("$DIR/templates/base/include.php");

$date = $_GET['date'];
$pageTitle = "Замовлення {$_GET['status']} за $date";
if (isset($_GET['period']))
    $pageTitle .= " / {$_GET['period']}";
include("$DIR/templates/base/header.php");
include("$DIR/templates/base/sidebar.php");

global $router;

if (!isset($analytic))
    $analytic = new Analytic();

// Якщо за посиланням є параметр period, в таблиці будуть показуватися замовлення за період з date по period
if (isset($_GET['period'])) {
    $orders = $analytic->getAllOrdersForPeriod(
        ['start' => $_GET['date'], 'end' => $_GET['period']],
        $_GET['field']
    )['orders'] ?? [];
}
// Якщо за посиланням немає параметру period, в таблиці замовлень будуть показуватися тільки замовлення за певниj день
else {
    $orders = $analytic->getAllOrdersByDate($date, $_GET['field'])['orders'] ?? [];
}

echo "<h1>$pageTitle</h1>";
?>

<script>
    function changeDate() {
        // Проводить редірект на сторінку з іншим параметром date

        // Отримуємо поточний URL
        let currentUrl = window.location.href;

        // Встановлюємо нову дату, яку хочемо вставити
        let newDate = document.getElementById('date-start').value;

        // Замінюємо старий параметр дати новим
        let newUrl = currentUrl.replace(/(date=)[^&]+/, '$1' + newDate);

        // Змінюємо адресу в браузері на новий URL
        window.location.href = newUrl;
    }

    function changePeriod() {
        // Проводить редірект на сторінку з іншим параметром date

        // Отримуємо поточний URL
        let currentUrl = window.location.href;

        // Встановлюємо нову дату, яку хочемо вставити
        let newDate = document.getElementById('date-end').value;

        // Замінюємо старий параметр дати новим
        let newUrl = currentUrl.replace(/(period=)[^&]+/, '$1' + newDate);

        // Змінюємо адресу в браузері на новий URL
        window.location.href = newUrl;
    }
</script>

<label for="date-start">I крапка</label>
<input onchange="changeDate()" type="date" id="date-start" value="<?php echo $date; ?>">

<?php
if (isset($_GET['period'])){
    $dinput = '<br><label for="date-end">II крапка</label>';
    $dinput .= "<input onchange='changePeriod()' type='date' id='date-end' value='{$_GET['period']}'>";
    echo $dinput;
}
?>

<?php include "$DIR/templates/orders/table.php"; ?>
