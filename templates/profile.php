<?php

include('base/include.php');
$user = User::get($_SESSION['user']['id']);
$right = $user->getUserRights();

$pageTitle = "Клієнти";
include('base/header.php');
include('base/sidebar.php');
?>


<h1>Профіль</h1>
<ul>
    <li>Username: <?php echo $user->getUsername() ?></li>
    <li>Рівень прав: <?php echo $right->getSlug() ?></li>
    <li><a href="/logout">Вийти</a></li>
</ul>

<!--Форма зміни паролю-->
<h2>Форма зміни паролю</h2>
<form method="post" action="../forms/passwordEdit.php">
    <label>
        Новий пароль
        <input type="password" name="password" placeholder="********" min="8">
    </label>
    <input type="submit" value="Змінити">
</form>

<?php // Обробчик помилок, що можуть виникнути при зміні паролю
if (isset($_SESSION['error'])) {
    echo "<div class='error-message'>";

    echo '<h3>ERROR</h3>';
    echo '<p>' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);

    echo '</div>';
}
?>

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


<?php include('base/footer.php'); ?>
