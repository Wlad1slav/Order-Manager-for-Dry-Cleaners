<?php
require_once "Invoice.php";
global $router;
?>

<p>Зображення, що буде показуватися в квитанції</p>

<div style="display: flex;">
    <img src="<?php echo Invoice::getJsonConfigElement('Image')['path']; ?>" alt="">
    <form action="<?php echo $router->url('editInvoiceImage'); ?>"
          method="post" enctype="multipart/form-data"
          style="padding-left: var(--medium-padding)">
        <input type="file" id="invoice-img" name="invoice-img" accept="image/*">
        <input type="checkbox" id="displayed-invoice-img" name="displayed-invoice-img"
        <?php if (Invoice::getJsonConfigElement('Image')['displayed']) echo 'checked' ?>>
        <label for="displayed-invoice-img">Показувати в квитанції</label>

        <input style="float: right;" type="submit" value="Зберегти">
    </form>
</div>
