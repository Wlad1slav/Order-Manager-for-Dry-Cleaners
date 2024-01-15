<?php
global $router;
User::checkLogin();
$right = User::getLoginUser()->getUserRights();
?>
<div class="sidebar">
        <?php
        /**
         * @var $sidebar
         * @var $pageTitle
         */
        foreach ($sidebar as $row => $link) {
            if ($link['right'] == 'default' or $link['right'] == $right) { // Перевірка рівня прав
                if ($link['url'] == $_SERVER['REQUEST_URI']) {
                    // Якщо користувач знаходиться на сторінці, то вона підсвідчується
                    echo "<p><b>$row</b></p>";
                    continue;
                }
                echo "<p><a href=\"{$link['url']}\">$row</a></p>"; // Вивод посилання в сайдбарі
            }
        }
        ?>
</div>

<div class="content">