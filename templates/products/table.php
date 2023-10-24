<!--ТАБЛИЦЯ ПРОДУКЦІЇ-->
<table id="products">
    <thead>
    <tr>
        <th>ID</th>
        <th>Назва</th>
        <th>Ціна</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach(array_reverse(Goods::getAll()) as $products) {
        echo '<tr>';

        foreach ($products as $value)
            echo "<th>$value</th>";

        echo '</tr>';
    }
    ?>
    </tbody>
</table>