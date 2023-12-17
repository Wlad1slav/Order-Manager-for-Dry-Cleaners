<?php
require_once "Invoice.php";
global $router;

$invoiceTexts = Invoice::getJsonConfigElement('Text');
?>

<p>Інформація, що буде показуватися в квитанції (HTML friendly)</p>

<form action="<?php echo $router->url('editInvoiceInfo'); ?>" method="post" style="display: flex; flex-direction: column;">

    <label for="business-info">Інформація про ваш бізнес</label>
    <input type="text" id="business-info" name="business-info" value="<?php echo $invoiceTexts['Information']['Business'] ?>">

    <label for="address-info">Адреса вашого бізнесу</label>
    <input type="text" id="address-info" name="address-info" value="<?php echo $invoiceTexts['Information']['Address'] ?>">

    <label for="phone-info">Номер телефону вашого бізнесу</label>
    <input type="text" id="phone-info" name="phone-info" value="<?php echo $invoiceTexts['Information']['Phone'] ?>">

    <label for="email-info">Пошта вашого бізнесу</label>
    <input type="text" id="email-info" name="email-info" value="<?php echo $invoiceTexts['Information']['Email'] ?>">

    <label for="top-text">Додаткова інформація зверху</label>
    <textarea id="top-text" name="top-text" style="height: 150px;"><?php echo $invoiceTexts['Start'] ?></textarea>

    <label for="bottom-text">Додаткова інформація знизу</label>
    <textarea id="bottom-text" name="bottom-text" style="height: 150px;"><?php echo $invoiceTexts['End'] ?></textarea>

    <input type="submit" value="Зберегти">

</form>