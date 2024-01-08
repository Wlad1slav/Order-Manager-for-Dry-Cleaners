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
            <a href="#" class="statistic">
                <?php echo $orders['Month']['date_create']['amount']; ?>
            </a>

            <div class="additional-statistic">
                <p>🗓️</p>
                <div>
                    <a href="#">У відповідний день:
                        <?php echo $orders['LastMonth']['date_create']['amount']; ?> зам.
                    </a>

                    <a href="#"> Усього за минулий місяць:
                        <?php echo $orders['WholeLastMonth']['date_create']['amount']; ?> зам.
                    </a>
                </div>
            </div>
        </div>

        <div class="analytic-container">
            <!-- Показує кількість замовлень, що були ОПЛАЧЕНІ сьогодні і вчора   -->
            <h3>Оплачені замовлення</h3>
            <a href="#" class="statistic">
                <span class="not-important">(<?php echo $orders['Month']['date_payment']['amount']; ?>) </span>
                <?php echo $orders['Month']['date_payment']['cash']; ?> ₴
            </a>

            <div class="additional-statistic">
                <p>💰</p>
                <div>
                    <a href="#">У відповідний день:
                        <?php echo $orders['LastMonth']['date_payment']['cash']; ?> ₴
                    </a>

                    <a href="#"> Усього за минулий місяць:
                        <?php echo $orders['WholeLastMonth']['date_payment']['cash']; ?> ₴
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>