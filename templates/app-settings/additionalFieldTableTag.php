<table>
    <tr>
        <th>Назва</th>
        <th>Тип поля</th>
        <th>Default</th>
        <th>Варіації</th>
        <th>Є в квитанції</th>
    </tr>

    <?php
    if (!isset($fieldsArray))
        $fieldsArray = new ProductAdditionalFields();
    if (!isset($router))
        global $router;

    $fieldIndex = 0; // Потрібно для отримання посилання на видалення поля

    foreach ($fieldsArray->getFields() as $field) {
        echo '<tr>';

        foreach ($field as $key => $value) {
            if ($value === true) $value = '<span class="accept">так</span>';
            elseif ($value === false) $value = '<span class="cancel">ні</span>';
            elseif (empty($value)) $value = '...';

            if ($key === 'possibleValues') {
                echo '<td>';
                if (count($value) !== 1)
                    foreach ($value as $element)
                        echo "$element. ";
                echo '</td>';
            } else
                echo "<td>$value</td>";
        }

        $deleteLink = $router->url('fieldRemove') . "?index=$fieldIndex";
        echo "<td><a style='font-weight: 1000' class='red-text' href='$deleteLink'>X </a></td>";

        $fieldIndex++;

        echo '</tr>';
    }

    ?>
</table>