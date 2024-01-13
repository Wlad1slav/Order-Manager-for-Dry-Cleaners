<?php
if (!isset($analytic))
    $analytic = new Analytic();
if (!isset($orders))
    $orders = $analytic->get();
if (!isset($router))
    global $router;

?>


<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Клієнт</th>
        <th>Сума</th>
    </tr>
    </thead>

    <tbody>

    <?php


    foreach ($orders['Today']['date_create']['orders'] as $order) {
        $tr = '<tr>';

        // id замовлення з посиланням на таблицю 
        $tr .= "<th>
                <a href='{$router->url(
                            'ordersTable', 
                            [], 
                            "order-{$order['id']}")}'>{$order['id']}</a></th>";

        $tr .= '<th>'.Customer::get($order['id_customer'])->getFullName().'</th>';
        $tr .= "<th>{$order['total_price']} грн.</th>";
        $tr .= '</tr>';

        echo $tr;
    }

    ?>

    </tbody>
</table>
