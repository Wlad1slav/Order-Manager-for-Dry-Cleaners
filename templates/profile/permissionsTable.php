<?php
/**
 * @var $right
 */
?>
<div>
    <h2>Рівень доступу</h2>
    <div class="container">
        <?php
        foreach ($right->getPerms() as $key => $arr) {
            echo "<ul class='rights'><h3>$key</h3>";
            foreach ($arr as $el)
                echo "<li>$el</li>";
            echo '</ul>';
        }
        ?>
    </div>
</div>