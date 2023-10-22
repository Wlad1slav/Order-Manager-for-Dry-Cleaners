<?php
global $router;
if (empty($_SESSION['user']['id']))
    $router->redirect('login');
?>
<div class="sidebar">
        <?php
        /**
         * @var $sidebar
         * @var $pageTitle
         */
        foreach ($sidebar as $row => $link) {
            if ("$link" == $_SERVER['REQUEST_URI']) {
                echo "<p><b>$row</b></p>";
                continue;
            }
            echo "<p><a href=\"$link\">$row</a></p>";
        }
        ?>
</div>

<div class="content">