<?php
if (!isset($router))
    global $router;
?>
<div>
    <!--Форма створення нових клієнтів-->
    <form method="post" action="<?php echo $router->url('customerCreate'); ?>">
        <h2>Форма створення</h2>

        <label>
            <input name="name" type="text" placeholder="Ім'я" required>
        </label>

        <label>
            <input name="phone" type="tel" placeholder="Номер телефону">
        </label>

        <label>
            <input name="discount" type="number" min="0" max="99" placeholder="Знижка" value="0" required>
        </label>

        <label>
            <input name="advertisingCompany" type="text" placeholder="Рекламна кампанія">
        </label>

        <input type="submit" value="Додати">

    </form>
</div>