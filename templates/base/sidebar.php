<div class="sidebar">
    <ul>
        <?php
        foreach ($sidebar as $row => $link) {
            if ($link == '') {
                echo '<hr>';
                continue;
            } elseif ($row == $pageTitle) {
                echo "<li><b>$row</b></li>";
                continue;
            }
            echo "<li><a href=\"$link\">$row</a></li>";
        }
        ?>
    </ul>
</div>

<div class="content">