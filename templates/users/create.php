<?php
if (!isset($router))
    global $router;
?>

<div>
    <!--Форма створення користувачів-->
    <form method="post" action="<?php echo $router->url('userCreate') ?>">
        <h2>Форма створення</h2>
        <label>
            <input name="username" type="text" placeholder="Логін" required>
        </label>

        <label>
            <input name="password" type="password" placeholder="Пароль" required>
        </label>

        <label>
            <select name="rights" required>
                <option value='default'>Роботник</option>
                <option value='root'>Адміністратор</option>
            </select>
        </label>

        <input type="submit" value="Додати">

    </form>
</div>