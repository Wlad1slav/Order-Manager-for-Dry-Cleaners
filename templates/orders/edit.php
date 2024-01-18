<?php
global $DIR;
include("$DIR/templates/base/include.php");

$orderId = intval($_GET['id']);
$pageTitle = "Редагувати замовлення №$orderId";


include("$DIR/templates/base/header.php");
include("$DIR/templates/base/sidebar.php");

global $router;

$order = Order::get($orderId); // Замовлення
//$orderSettings = json_decode($order->getSettings()['orders_config'], true); // Налаштування замовлення
$products = $order->getProductions(); // Масив виробів

$additionalFields = $order->getSettings()['additional_fields']; // Додаткові поля замовлння
if (is_string($additionalFields))
    $additionalFields = json_decode($additionalFields, true);
?>

<h1>Замовлення №<?php echo $orderId; ?></h1>

<form class="order-create-form" method="post" action="<?php echo $router->url('orderEditForm', ['id'=>$orderId]); ?>">

    <!-- Контактні данні клієнта -->
    <h3>Замовник <?php echo $order->getCustomer()->getFullName(); ?></h3>

    <div class="products"> <!-- Вироби -->
        <?php

        for ($i = 1; $i <= count($products); $i++) {

            echo '<div class="product">';
            echo "<h2>Виріб $i</h2>";

            // Найменування виробу
            echo "<label for='good-name-$i'>Найменування виробу <span class='red-text'>*</span></label>";
            echo "<input list='goods-$i' name='good-name-$i' id='good-name-$i' class='good-name' value='{$products[$i-1]->getGoods()->getName()}'>";

            echo Goods::getProductDataList($i);

            // Кількість
            echo "<label for='amount-$i'>Кількість <span class='red-text'>*</span></label>";
            echo '<div>';
            echo "<input type='number' name='amount-$i' id='amount-$i' value='{$products[$i-1]->getAmount()}' min='1'>";
            echo "<input type='number' name='price-per-one-$i' id='price-per-one-$i' placeholder='₴ за шт.' value='{$products[$i-1]->getGoods()->getPrice()}'>";
            echo '</div>';

            // Ціна
            echo "<label for='price-$i'>Ціна <span class='red-text'>*</span></label>";
            echo "<input type='number' name='price-$i' id='price-$i' min='0' placeholder='x₴' value='{$products[$i-1]->getPrice()}'>";

            // Знижка за виріб
            echo "<label for='discount-$i'>Знижка на виріб <span class='red-text'>*</span></label>";
            echo "<input type='number' name='discount-$i' id='discount-$i' min='0' max='99' placeholder='x%' value='{$products[$i-1]->getDiscount()}'>";

            // Примітки
            echo "<textarea name='notes-textarea-$i'>{$products[$i-1]->getNote()}</textarea>";

            echo '<h3>Додаткові параметри</h3>'; // Додаткові параметри
            echo '<a href="' . $router->url('settingsPage') . '#additionalProperties" style="font-size: x-small">Налаштувати додаткові параметри</a>';

            $filedNum = 0;
            $f = new ProductAdditionalFields();
            foreach ($additionalFields as $fieldName=>$fieldInfo) {
                $filedNum++;
                echo $f->generateHTML($fieldName, $fieldInfo, $filedNum, $i);
            }

            echo '</div>';

        }

        ?>
    </div>

    <p>Загальна ціна: <span class="important"><b id="total-price">0</b>₴</span></p>

    <input type="submit" value="Створити">

</form>

<!--<script src="../../static/javascript/orderCreate.js"></script>-->

<?php include("$DIR/templates/base/footer.php"); ?>
