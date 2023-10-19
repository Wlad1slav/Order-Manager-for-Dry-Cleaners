<?php
include('base/include.php');

$pageTitle = "Нове замовлення";
include('base/header.php');
include('base/sidebar.php');
?>

<h1>Нове замовлення</h1>

<form class="order-create-form">

    <!-- Контактні данні клієнта -->
    <label for="customer-name">Клієнт</label>
    <input list="customers" name="customer-name" id="customer-name" placeholder="П.І.Б." required>
    <datalist id="customers">
        <?php

        foreach (Customer::getAll() as $customer) {
            $customerID = $customer['id'];
            $name = $customer['name'];
            $phone = $customer['phone'];
            $discount = $customer['discount'];

            echo "<option value='$name ($phone) [$discount%]' data-customerID='$customerID' data-discount='$discount'></option>";
        }

        ?>
    </datalist>

    <!-- Знижка клієнта -->
    <label for="order-discount">Знижка</label>
    <input type="number" name="order-discount" id="order-discount" min="0" max="99" placeholder="0%">

    <div class="products"> <!-- Вироби -->
    <?php

    for ($i = 1; $i <= 5; $i++) {

        echo '<div class="product">';
        echo "<h2>Виріб $i</h2>";

        // Найменування виробу
        echo "<label for='good-name-$i'>Найменування виробу</label>";
        echo "<input list='goods-$i' name='good-name-$i' id='good-name-$i' required>";
        echo "<datalist id='goods-$i'>";
        foreach (Goods::getAll() as $good) {
            $goodID = $good['0'];
            $name = $good['1'];
            $price = $good['2'];

            echo "<option value='$name' data-goodID='$goodID' data-price='$price'></option>";
        }
        echo '</datalist>';

        // Кількість
        echo "<label for='amount-$i'>Кількість</label>";
        echo '<div>';
        echo "<input type='number' name='amount-$i' id='amount-$i' value='1' min='1' required>";
        echo "<input type='number' name='price-per-one-$i' id='price-per-one-$i' placeholder='₴ за шт.' required>";
        echo '</div>';

        // Ціна
        echo "<label for='price-$i'>Ціна</label>";
        echo "<input type='number' name='price-$i' id='price-$i' min='0' placeholder='X₴' required>";

        // Примітки
        echo "<label for='notes-$i'>Примітки</label>";
        echo "<select name='notes-$i' id='notes-$i' multiple required>";
        echo "<option value='Важке забруднення'>Важке забруднення</option>";
        echo '</select>';
        echo "<textarea name='notes-textarea-$i'></textarea>";

        echo '<h3>Додаткові параметри</h3>'; // Додаткові параметри
        echo '<a href="/settings#additionalProperties" style="font-size: x-small">Налаштувати додаткові параметри</a>';

        echo '</div>';

    }

    ?>
    </div>

<p>Загальна ціна: <span class="important"><b id="total-price">0</b>₴</span></p>

<input type="submit" value="Створити">

</form>

<script src="../static/javascript/orderCreate.js"></script>

<?php include('base/footer.php'); ?>
