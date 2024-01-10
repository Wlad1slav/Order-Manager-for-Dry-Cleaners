<?php

if (!isset($analytic))
    $analytic = new Analytic();
if (!isset($orders))
    $orders = $analytic->get();
if (!isset($router))
    global $router;

?>
<div class="analytic-section">

    <h2>За місяць</h2>

    <div class="analytic-containers month">

        <div class="analytic-container">
            <!-- Показує кількість замовлень, що були СТВОРЕННІ сьогодні і вчора   -->
            <h3>Нові замовлення</h3>
            <a href="<?php echo $router->url('ordersByDate',
                ['date'=>$orders['Month']['period']['start'], 'period'=>$orders['Month']['period']['end'],
                'status'=>'створені', 'field'=>'date_create']) ?>" class="statistic">
                <?php echo $orders['Month']['date_create']['amount']; ?>
            </a>

            <div class="additional-statistic">
                <p>🗓️</p>
                <div>
                    <a href="<?php echo $router->url('ordersByDate',
                        ['date'=>$orders['LastMonth']['period']['start'],
                            'period'=>$orders['LastMonth']['period']['end'],
                            'status'=>'створені', 'field'=>'date_create']) ?>">
                        У відповідний день:
                        <?php echo $orders['LastMonth']['date_create']['amount']; ?> зам.
                    </a>

                    <a href="<?php echo $router->url('ordersByDate',
                        ['date'=>$orders['WholeLastMonth']['period']['start'],
                            'period'=>$orders['WholeLastMonth']['period']['end'],
                            'status'=>'створені', 'field'=>'date_create']) ?>">
                        Усього за минулий місяць:
                        <?php echo $orders['WholeLastMonth']['date_create']['amount']; ?> зам.
                    </a>
                </div>
            </div>
        </div>

        <div class="analytic-container">
            <!-- Показує кількість замовлень, що були ОПЛАЧЕНІ сьогодні і вчора   -->
            <h3>Оплачені замовлення</h3>
            <a href="<?php echo $router->url('ordersByDate',
                ['date'=>$orders['Month']['period']['start'], 'period'=>$orders['Month']['period']['end'],
                    'status'=>'оплачені', 'field'=>'date_payment']) ?>" class="statistic">
                <span class="not-important">(<?php echo $orders['Month']['date_payment']['amount']; ?>) </span>
                <?php echo $orders['Month']['date_payment']['cash']; ?> ₴
            </a>

            <div class="additional-statistic">
                <p>💰</p>
                <div>
                    <a href="<?php echo $router->url('ordersByDate',
                        ['date'=>$orders['LastMonth']['period']['start'],
                            'period'=>$orders['LastMonth']['period']['end'],
                            'status'=>'оплачені', 'field'=>'date_payment']) ?>">
                        У відповідний день:
                        <?php echo $orders['LastMonth']['date_payment']['cash']; ?> ₴
                    </a>

                    <a href="<?php echo $router->url('ordersByDate',
                        ['date'=>$orders['WholeLastMonth']['period']['start'],
                            'period'=>$orders['WholeLastMonth']['period']['end'],
                            'status'=>'оплачені', 'field'=>'date_payment']) ?>">
                        Усього за минулий місяць:
                        <?php echo $orders['WholeLastMonth']['date_payment']['cash']; ?> ₴
                    </a>
                </div>
            </div>
        </div>

        <div class="analytic-container">
            <!-- Показує середній чек за замовлення   -->
            <h3>Cередній чек</h3>
            <p class="statistic">
                <?php echo $orders['Month']['date_create']['averageCheck']; ?> ₴
            </p>
        </div>

        <div class="analytic-container">
            <!-- Показує суми, що були оплачені готівкою і карткою   -->
            <h3>Спосіб оплати</h3>
            <p>🤑 Готівкою -
                <span class="not-important">
                    (<?php echo $orders['Month']['date_payment']['payment_type']['cash']['amount']; ?>)
                </span>
                <b><?php echo $orders['Month']['date_payment']['payment_type']['cash']['total_cash']; ?> ₴</b>
            </p>
            <p>💳 Карткою -
                <span class="not-important">
                    (<?php echo $orders['Month']['date_payment']['payment_type']['card']['amount']; ?>)
                </span>
                <b><?php echo $orders['Month']['date_payment']['payment_type']['card']['total_cash']; ?> ₴</b>
            </p>
        </div>

    </div>

</div>