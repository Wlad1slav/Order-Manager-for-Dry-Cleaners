<?php
global $router;
?>

<h3>Нотатки</h3>
<p>Швидкий вибір нотаток при створенні замовлення</p>
<form method="post" action="<?php echo $router->url('notesFieldSave'); ?>">
    <label for="notes-default">Які нотатки ви частіше за все використовуєте (через кому)</label>
    <textarea name="notes-default" id="notes-default" cols="50" rows="5"><?php
        $orderSettings = Order::getOrdersSettings();
        foreach ($orderSettings['Quick note selection'] as $note)
            echo "$note,";
        ?></textarea>
    <input type="submit" value="ЗБЕРЕГТИ">
</form>