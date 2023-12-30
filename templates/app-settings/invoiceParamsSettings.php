<?php
require_once "Invoice.php";
if (!isset($router))
    global $router;
if (!isset($invoiceSettings))
    $invoiceSettings = Invoice::getJsonConfig();
?>

<p>Які параметри ви хочете використовувати в квитанціях?</p>

<input oninput="checkInput(false)" type="radio" id="old-relevant" name="relevant-or-no" value="old"
        <?php if (!$invoiceSettings['Current']) echo 'checked' ?>>
<label for="old-relevant">Релевантні на момент створення замовлення (рекомендується)</label>
<br>
<input oninput="checkInput(true)" type="radio" id="relevant" name="relevant-or-no" value="current"
    <?php if ($invoiceSettings['Current']) echo 'checked' ?>>
<label for="relevant">Релевантні зараз (ті, що використовуваються зараз)</label>

<p id="error"></p>

<script>
    function checkInput(current) {
        if (document.getElementById('relevant').checked)
            document.getElementById('error').innerText = "Обережно! З цім параметром при зміні налаштувань можуть статися помилки в час перегляду квитанцій!";
        else document.getElementById('error').innerText = "";

        if (current !== null) {
            $.ajax({
                type: "GET",
                url: "<?php echo $router->url('editInvoiceCurrentSettings'); ?>",
                data: {current: current},
            });
        }
    }

    checkInput(null);
</script>
