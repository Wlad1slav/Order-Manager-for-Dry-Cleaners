<?php
require_once "Invoice.php";
global $router;
?>

<p>Зображення, що буде показуватися в квитанції</p>

<div class="img-settings">
    <img src="<?php echo Invoice::getJsonConfigElement('Image')['path']; ?>" alt="">
    <form action="<?php echo $router->url('editInvoiceImage'); ?>"
          method="post" enctype="multipart/form-data">
        <input type="file" id="invoice-img" name="invoice-img" accept="image/*">
        <div>
            <input type="checkbox" id="displayed-invoice-img" name="displayed-invoice-img"
            <?php if (Invoice::getJsonConfigElement('Image')['displayed']) echo 'checked' ?>>
            <label for="displayed-invoice-img">Показувати в квитанції</label>
        </div>

        <input type="submit" value="Зберегти">
    </form>
</div>
