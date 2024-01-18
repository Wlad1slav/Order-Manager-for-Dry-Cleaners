<?php
global $DIR;
include("$DIR/templates/base/include.php");

$pageTitle = "Нове замовлення";
include("$DIR/templates/base/header.php");
include("$DIR/templates/base/sidebar.php");

global $router;

$orderSettings = Order::getJsonConfig();
?>

<h1>Нове замовлення</h1>

<form class="order-create-form" method="post">

    <!-- Контактні данні клієнта -->
    <label for="customer-name">Клієнт <span class="red-text">*</span></label>
    <input list="customers" name="customer-name" id="customer-name" placeholder="П.І.Б." required>
    <datalist id="customers">
        <?php

        foreach (Customer::getAll() as $customer) {
            $customerID = $customer['id'];
            $name = $customer['name'];
            $phone = $customer['phone'];
            $discount = $customer['discount'];

            echo "<option value='$name' data-customerID='$customerID' data-discount='$discount'></option>";
        }

        ?>
    </datalist>

    <div class="products"> <!-- Вироби -->
    <?php

    for ($i = 1; $i <= $orderSettings['Number of products']; $i++) {

        echo '<div class="product">';
        echo "<h2>Виріб $i</h2>"; // ✔

        // Найменування виробу
        echo "<label for='good-name-$i'>Найменування виробу <span class='red-text'>*</span></label>";
        echo "<input list='goods-$i' name='good-name-$i' id='good-name-$i' class='good-name'>";

        echo Goods::getProductDataList($i);

        // Кількість
        echo "<label for='amount-$i'>Кількість <span class='red-text'>*</span></label>";
        echo '<div>';
        echo "<input type='number' name='amount-$i' id='amount-$i' value='1' min='1'>";
        echo "<input type='number' name='price-per-one-$i' id='price-per-one-$i' placeholder='₴ за шт.'>";
        echo '</div>';

        // Ціна
        echo "<label for='price-$i'>Ціна <span class='red-text'>*</span></label>";
        echo "<input type='number' name='price-$i' id='price-$i' min='0' placeholder='x₴'>";

        // Знижка за виріб
        echo "<label for='discount-$i'>Знижка на виріб <span class='red-text'>*</span></label>";
        echo "<input type='number' name='discount-$i' id='discount-$i' min='0' max='99' placeholder='x%'>";

        // Примітки
        echo "<label for='notes-$i'>Примітки</label>";
        echo "<select name='notes-$i"."[]' id='notes-$i"."[]' multiple>";
        foreach ($orderSettings['Quick note selection'] as $noteOption)
            echo "<option value='$noteOption'>$noteOption</option>";
        echo '</select>';

        echo "<textarea name='notes-textarea-$i'></textarea>";

        echo '<h3>Додаткові параметри</h3>'; // Додаткові параметри
        echo '<a href="' . $router->url('settingsPage') . '#additionalProperties" style="font-size: x-small">Налаштувати додаткові параметри</a>';

        $additionalFields = new ProductAdditionalFields();
        $filedNum = 0;
        foreach ($additionalFields->getFields() as $fieldName=>$fieldInfo) {
            $filedNum++;
            echo $additionalFields->generateHTML($fieldName, $fieldInfo, $filedNum, $i);
            echo '<hr>';
        }

        echo '</div>';

    }

    ?>
    </div>

<p>Загальна ціна: <span class="important"><b id="total-price">0</b>₴</span></p>

<input type="submit" value="Створити">

</form>

<script src="../../static/javascript/orderCreate.js"></script>

<?php include("$DIR/templates/base/footer.php"); ?>
