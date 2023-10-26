<div class="container-margin">
    <h2>Додаткові поля замовлення</h2>

    <hr>
    <?php
    /**
     * @var $router
     */

    $fieldsArray = new ProductAdditionalFields();
    $fieldIndex = 0;
    foreach ($fieldsArray->getFields() as $field) {
        $deleteLink = $router->url('fieldRemove') . "?index=$fieldIndex";
        echo "<a style='font-weight: 1000' class='red-text' href='$deleteLink'>X </a>";
        foreach ($field as $key => $value) {
            if (empty($value)) $value = '...';

            if ($key === 'possibleValues' || $key === 3) {
                echo '<i>Варіації: ';
                foreach ($value as $element)
                    echo "| $element |";
                echo '</i>';
            }
            else {
//                print_r($value);
                echo "$value <b>=></b> ";
            }
        }
        $fieldIndex++;
        echo '<hr>';
    }
    ?>
</div>