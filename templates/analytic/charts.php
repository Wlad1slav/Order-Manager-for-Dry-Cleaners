<?php
require_once 'Analytic.php';

if (!isset($analytic))
    $analytic = new Analytic();
if (!isset($orders))
    $orders = $analytic->get();
if (!isset($router))
    global $router;

// Функція для порівняння дат
function compareByDateCreate($a, $b) {
    $dateA = strtotime($a['date_create']);
    $dateB = strtotime($b['date_create']);

    if ($dateA == $dateB) {
        return 0;
    }
    return ($dateA < $dateB) ? -1 : 1;
}

if (isset($orders['Month']))
    $ordersForChart = $orders['Month']['date_payment']['orders'];
else $ordersForChart = $orders;

// Сортування замовлень по даті
usort($ordersForChart, "compareByDateCreate");

$ordersAmount = [];
$ordersCash = [];
foreach ($ordersForChart as $order) {
    // Розрахунок кількості створенних замовлень по дням
    $date = Analytic::validateDateTime($order['date_create']);
    if (!isset($ordersAmount[$date])) {
        $ordersAmount[$date]['amount'] = 1;
        $ordersAmount[$date]['date'] = $date;
    }
    else $ordersAmount[$date]['amount'] += 1;

    // Розрахунок кешу по дням
    $date = $order['date_payment'];
    if (!isset($ordersCash[$date])) {
        $ordersCash[$date]['date'] = $date;
        $ordersCash[$date]['total_cash'] = $order['total_price'];
    }
    else $ordersCash[$date]['total_cash'] += $order['total_price'];
}

?>

<canvas id="chart-cash-month" class="chart" height="250"></canvas>
<canvas id="chart-amount-month" class="chart" height="250"></canvas>

<script>
    // Генерація графіку ОПЛАТИ замовлень за місяць

    var data_all_orders = <?php echo json_encode($ordersCash); ?>;

    var ctx = document.getElementById('chart-cash-month').getContext('2d');

    var chart = new Chart(ctx, {
        // Тип графіка
        type: 'line',

        // Дані для графіка
        data: {
            labels: Object.values(data_all_orders).map(item => item.date),
            datasets: [
                {
                    label: 'Оплачено',
                    data: Object.values(data_all_orders).map(item => item.total_cash),
                    backgroundColor: 'rgba(117,224,114,0.5)',
                    borderColor: 'rgba(56,101,56,0.5)',
                    borderWidth: 1
                },

            ]
        },

        // Конфігурація
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>


<script>
    // Генерація графіку СТВОРЕННЯ замовлень за місяць
    var data_all_orders = <?php echo json_encode($ordersAmount); ?>;


    var ctx = document.getElementById('chart-amount-month').getContext('2d');

    var chart = new Chart(ctx, {
        // Тип графіка
        type: 'bar',

        // Дані для графіка
        data: {
            labels: Object.values(data_all_orders).map(item => item.date),
            datasets: [
                {
                    label: 'Створено',
                    data: Object.values(data_all_orders).map(item => item.amount),
                    backgroundColor: 'rgba(82,197,255,0.5)',
                    borderColor: 'rgba(52,126,162,0.5)',
                    borderWidth: 1
                },

            ]
        },

        // Конфігурація
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
