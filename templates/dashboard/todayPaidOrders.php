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
        <th>Тип олпати</th>
        <th>ID</th>
        <th>Клієнт</th>
        <th>Сума</th>
    </tr>
    </thead>

    <tbody>

    <?php


    foreach ($orders['Today']['date_payment']['orders'] as $order) {
        $tr = '<tr>';

        if ($order['type_of_payment'] == 'cash')
            $tr = '<th class="important-4 cash">готівка</th>';
        elseif ($order['type_of_payment'] == 'card')
            $tr = '<th class="important-4 card">картка</th>';
        else $tr = '<th><i>Очікується...</i></th>';

        // id замовлення з посиланням
        $tr .= "<th>
                <a href='{$router->url(
                            'orderEditForm',            // Посилання на форму редагування замовлення
                            ['id'=>$order['id']],
                            )}'>{$order['id']}</a></th>";

        $tr .= '<th>'.Customer::get($order['id_customer'])->getFullName().'</th>';
        $tr .= "<th>{$order['total_price']} грн.</th>";
        $tr .= '</tr>';

        echo $tr;
    }

    ?>

    </tbody>
</table>
