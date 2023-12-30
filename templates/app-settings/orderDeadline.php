<?php
if (!isset($router))
    global $router;
if (!isset($orderSettings))
    $orderSettings = Order::getJsonConfig();
?>

<form method="post" action="<?php echo $router->url('editDeadline') ?>">

    <h3>Дедлайн замовлень</h3>
    <p>За скількі днів ви бажаєте, щоб закінчувався термін замовлення?</p>
    <input type="number" name="DEADLINE-DAYS" id="deadline" value="<?php echo $orderSettings['Deadline'] ?>"
           style="width: 15%;" min="1">
    <label for="deadline">днів</label>
    <input type="submit" value="Зберегти">

</form>