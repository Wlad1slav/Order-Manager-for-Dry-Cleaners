<table>
    <tr>
        <th>Назва</th>
        <th>Тип поля</th>
        <th>Стандарт</th>
        <th>Варіації</th>
        <th></th>
    </tr>

    <?php
    /**
     * @var $fieldsArray
     * @var $router
     * */
    $fieldIndex = 0; // Потрібно для отримання посилання на видалення поля

    foreach ($fieldsArray->getFields() as $field) {
        echo '<tr>';

        foreach ($field as $key => $value) {
            if (empty($value)) $value = '...';

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