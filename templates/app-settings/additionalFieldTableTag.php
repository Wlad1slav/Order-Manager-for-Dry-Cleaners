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

    foreach ($fieldsArray->getFields() as $fieldName => $fieldInfo) {
        // Вивод додаткових полів
        echo '<tr>';

        echo "<td>$fieldName</td>"; // Назва поля

        foreach ($fieldInfo as $key => $value) {
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
        $status = Invoice::getJsonConfigElement('Fields')['Additional'][$fieldName]['displayed'];
        if ($status === true) $status = '<span class="accept">так</span>';
        elseif ($status === false) $status = '<span class="cancel">ні</span>';
        elseif (empty($status)) $status = '';
        echo "<td>$status</td>";

        // Створення посилання для видалення полю
        $deleteLink = $router->url('fieldRemove', ['field'=>$fieldName]);
        echo "<td><a style='font-weight: 1000' class='red-text' href='$deleteLink'>X </a></td>";

        echo '</tr>';
    }

    ?>
</table>