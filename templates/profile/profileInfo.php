<?php
/**
 * @var $user
 * @var $right
 * @var $router
 * */
?>
<div>
    <h1>Профіль</h1>
    <ul>
        <li>Username: <?php echo $user->getUsername(); ?></li>
        <li>Рівень прав: <?php echo $user->getUserRights(); ?></li>
        <li><a href="<?php echo $router->url('logout') ?>" class="underline-animation">Вийти</a></li>
    </ul>
</div>