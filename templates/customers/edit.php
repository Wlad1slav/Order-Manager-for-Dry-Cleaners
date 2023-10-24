<?php global $router ?>
<script src="../../static/javascript/edit.js"></script>
<div>
    <!--Форма редагування клієнтів-->
    <form action="<?php echo $router->url('customerEdit') ?>" method="post" id="edit">
        <h2>Форма редагування</h2>

        <label>
            <input name="id" id="id" type="number" min="0" placeholder="ID" required>
        </label>

        <label>
            <input name="name" id="name" type="text" placeholder="Ім'я" required>
        </label>

        <label>
            <input name="phone" id="phone" type="tel" placeholder="Номер телефону">
        </label>

        <label>
            <input name="discount" id="discount" type="number" min="0" max="99" placeholder="0%" required>
        </label>

        <label>
            <input name="advertisingCompany" id="advertising_company" type="text" placeholder="Рекламна кампанія">
        </label>

        <input type="submit" value="Змінити">

    </form>
</div>