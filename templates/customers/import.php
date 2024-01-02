<div id="import">
    <h2>Імпорт клієнтів</h2>
    <b> :: </b>
    <a href="/settings/templates/customers_import_template.csv" class="cta-text underline-animation">Шаблон для імпорту</a>
    <b> :: </b>
    <a href="<?php echo $router->url('customersExport') ?>" class="cta-text underline-animation">Експортувати</a>
    <b> :: </b>
    <form action="<?php echo $router->url('customersImport') ?>" method="post" enctype="multipart/form-data" id="import">
        <input type="file" name="fileToUpload" id="fileToUpload" accept=".csv">
        <input type="submit" value="Завантажити" name="submit">
    </form>
</div>