<?php
if (!isset($router))
    global $router;
?>

<p><b>Додати нове поле</b></p>

<form class="fields-create" method="post" action="<?php echo $router->url('fieldAdd'); ?>">
    <label for="fieldName">Назва поля</label>
    <input type="text" name="fieldName" id="fieldName" required>

    <label for="fieldType">Тип поля</label>
    <select name="fieldType" id="fieldType" required>
        <?php
        foreach (ProductAdditionalFields::TYPES as $type)
            echo "<option value='$type'>$type</option>"
        ?>
    </select>

    <label for="defaultFieldValue">Значення за замовчуванням</label>
    <input type="text" name="defaultFieldValue" id="defaultFieldValue">

    <label for="availableValues">Швидкий вибір значень (через кому)</label>
    <textarea name="availableValues" id="availableValues"></textarea>
    <div>
        <input type="submit" value="Додати">
    </div>
</form>