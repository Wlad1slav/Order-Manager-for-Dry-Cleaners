<?php
require_once "Invoice.php";
if (!isset($router))
    global $router;
if (!isset($invoiceSettings))
    $invoiceSettings = Invoice::getJsonConfig();
?>

<p>Скільки квитанцій показувати на однієї сторінці?</p>
<form action="<?php echo $router->url('editInvoiceAmount') ?>" method="post">
    <label for="invoice-amount">Кількість квитанцій</label>
    <input type="number" id="invoice-amount" name="invoice-amount"
    value="<?php echo $invoiceSettings['Amount']; ?>"
    style="width: 20%;" min="1" max="3">
    <input type="submit" value="Зберегти">
</form>