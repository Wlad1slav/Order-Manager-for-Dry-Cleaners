<?php
if (!isset($router))
    global $router;
?>

<div>
    <!--Форма зміни паролю-->
    <h2>Форма зміни паролю</h2>
    <form method="post" action="<?php echo $router->url('passwordEdit') ?>">
        <label>
            Новий пароль
            <input type="password" name="password" placeholder="********" min="8">
        </label>
        <input type="submit" value="Змінити">
    </form>
</div>