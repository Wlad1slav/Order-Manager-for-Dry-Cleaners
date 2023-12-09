<table>
    <tr>
        <th>Назва</th>
        <th>Тип поля</th>
        <th>Default</th>
        <th>Варіації</th>
        <th>Є в квитанції</th>
    </tr>

    <?php
    require_once 'Invoice.php';

    if (!isset($fieldsArray))
        $fieldsArray = new ProductAdditionalFields();
    if (!isset($router))
        global $router;

    $fieldIndex = 0; // Потрібно для отримання посилання на видалення поля

    foreach ($fieldsArray->getFields() as $field) {
        // Вивод додаткових полів
        echo '<tr>';

        foreach ($field as $key => $value) {
            // Вивод даних поля
            if ($key === 'possibleValues') {
                echo '<td>';
                if (count($value) !== 1)
                    foreach ($value as $element)
                        echo "$element. ";
                echo '</td>';
            } else
                echo "<td>$value</td>";
        }

        // Вивод статусу поля
        $status = Invoice::getJsonConfigElement('Fields')['Additional'][$field['name']]['displayed'];
        if ($status === true) $status = '<span class="accept">так</span>';
        elseif ($status === false) $status = '<span class="cancel">ні</span>';
        elseif (empty($status)) $status = '';
        echo "<td>$status</td>";

        // Створення посилання для видалення полю
        $deleteLink = $router->url('fieldRemove', ['index'=>$fieldIndex]);
        echo "<td><a style='font-weight: 1000' class='red-text' href='$deleteLink'>X </a></td>";

        $fieldIndex++;

        echo '</tr>';
    }

    ?>
</table>