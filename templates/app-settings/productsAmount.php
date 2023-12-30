<?php
if (!isset($router))
    global $router;
if (!isset($orderSettings))
    $orderSettings = Order::getJsonConfig();
?>

<form method="post" action="<?php echo $router->url('editProductsAmount') ?>">

    <h3>Кількість виробів</h3>
    <p>Скільки виробів ви бажаєте, щоб було в замовленні?</p>
    <label for="products-amount">Кількість</label>
    <input type="number" name="products-amount" id="products-amount" value="<?php echo $orderSettings['Number of products'] ?>"
    style="width: 20%;">
    <input type="submit" value="Зберегти">

</form>