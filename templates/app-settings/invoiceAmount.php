<?php
require_once "Invoice.php";
global $router;
?>

<p>Скільки квитанцій показувати на однієї сторінці?</p>
<form action="<?php echo $router->url('editInvoiceAmount') ?>" method="post">
    <label for="invoice-amount">Кількість квитанцій</label>
    <input type="number" id="invoice-amount" name="invoice-amount"
    value="<?php echo Invoice::getJsonConfigElement('Amount'); ?>"
    style="width: 20%;" min="1" max="3">
    <input type="submit" value="Зберегти">
</form>