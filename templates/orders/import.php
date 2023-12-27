<?php
global $router;
?>

<div id="import">
    <h2>Імпорт замовлень</h2>
    <a class="cta-text underline-animation" href="\settings\templates\orders_import_template.csv">Завантажити шаблон для імпорту</a>

    <form action="<?php echo $router->url('ordersImport'); ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="orders-import" id="orders-import" accept="text/csv" required>
        <label for="orders-import">Таблиця замовлень (csv)</label> <br>
        <input type="submit" value="Імпортувати">
    </form>

    <p class="important-3">Важливо! Обов'язково використовувати шаблон для імпорту.</p>
</div>
