<div class="sidebar">

        <?php
        /**
         * @var $sidebar
         * @var $pageTitle
         */
        foreach ($sidebar as $row => $link) {
            if ($row == $pageTitle) {
                echo "<p><b>$row</b></p>";
                continue;
            }
            echo "<p><a href=\"$link\">$row</a></p>";
        }
        ?>
</div>

<div class="content">