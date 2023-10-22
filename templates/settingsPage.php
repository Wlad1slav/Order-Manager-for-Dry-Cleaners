<?php
include('base/include.php');

$pageTitle = "Налаштування";
include('base/header.php');
include('base/sidebar.php');

global $router;
?>

<h1>Налаштування</h1>

<div class="container-margin">
    <h2>Додаткові поля замовлення</h2>

    <hr>
    <?php
    $fieldsArray = new ProductAdditionalFields();
    $fieldIndex = 0;
    foreach ($fieldsArray->getFields() as $field) {
        $deleteLink = $router->url('fieldRemove') . "?index=$fieldIndex";
        echo "<a style='font-weight: 1000' class='red-text' href='$deleteLink'>X </a>";
        foreach ($field as $key => $value) {
            if (empty($value)) $value = '...';

            if ($key === 3) {
                echo '<i>Варіації: ';
                foreach ($value as $element)
                    echo "| $element |";
                echo '</i>';
            }
            else
                echo "$value <b>=></b> ";
        }
        $fieldIndex++;
        echo '<hr>';
    }
    ?>
</div>

<div class="container-margin">
    <h3>Форма створення нового поля</h3>

    <form class="fields-create" method="post">
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
        <input type="text" name="defaultFieldValue" id="defaultFieldValue" required>

        <label for="availableValues">Значення за замовчуванням (через кому)</label>
        <textarea name="availableValues" id="availableValues" required></textarea>

        <input type="submit" value="Створити">
    </form>
</div>

<?php include('base/footer.php'); ?>