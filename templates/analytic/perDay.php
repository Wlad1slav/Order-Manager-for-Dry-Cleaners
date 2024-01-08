<?php

if (!isset($analytic))
    $analytic = new Analytic();
if (!isset($orders))
    $orders = $analytic->get();
if (!isset($router))
    global $router;

?>
<div class="analytic-section">

<h2>За сьогодні</h2>

<div class="analytic-containers">

    <div class="analytic-container">
        <!-- Показує кількість замовлень, що були СТВОРЕННІ сьогодні і вчора   -->
        <h3>Нові замовлення</h3>
        <a href="<?php echo $router->url('ordersByDate', ['date'=>$orders['Today']['date'],
            'status'=>'створені', 'field'=>'date_create']) ?>" class="statistic">
            <?php echo $orders['Today']['date_create']['amount']; ?>
        </a>

        <a href="<?php echo $router->url('ordersByDate', ['date'=>$orders['Yesterday']['date'],
            'status'=>'створені', 'field'=>'date_create']) ?>">
            <?php echo '🗓️ Вчора: ' . $orders['Yesterday']['date_create']['amount']; ?>
        </a>
    </div>

    <div class="analytic-container">
        <!-- Показує кількість замовлень, що були ОПЛАЧЕНІ сьогодні і вчора   -->
        <h3>Оплачені замовлення</h3>
        <a href="<?php echo $router->url('ordersByDate', ['date'=>$orders['Today']['date'],
            'status'=>'оплачені', 'field'=>'date_payment']) ?>" class="statistic">
            <span class="not-important">(<?php echo $orders['Today']['date_payment']['amount']; ?>) </span>
            <?php echo $orders['Today']['date_payment']['cash']; ?> ₴
        </a>

        <a href="<?php echo $router->url('ordersByDate', ['date'=>$orders['Yesterday']['date'],
            'status'=>'оплачені', 'field'=>'date_payment']) ?>">
            <?php echo '💶️ Вчора: ' . $orders['Yesterday']['date_payment']['cash']; ?> ₴
        </a>
    </div>

</div>

</div>