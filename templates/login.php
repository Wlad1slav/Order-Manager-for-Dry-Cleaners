<?php
if (!empty($_SESSION['user']['id']))
    Router::redirect('/profile');

include('base/include.php');

$pageTitle = "Увійти";
include('base/header.php');
?>
<div class="content">
    <h1>Вітаємо!</h1>
    <h2>Будь ласка, увійдіть, щоб продовжити.</h2>

    <form method="post" class="login-form">
        <label for="login">Лоігн</label>
        <label>
            <input type="text" name="login" placeholder="Vladyslav">
        </label>

        <label for="password">Пароль</label>
        <label>
            <input type="password" name="password" placeholder="********">
        </label>

        <input type="submit" value="Увійти">

        <?php // Обробчик помилок, що можуть виникнути при створенні клієнта
        if (isset($_SESSION['error'])) {
            echo "<div class='error-message'>";

            echo '<h3>ERROR</h3>';
            echo '<p>' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);

            echo '</div>';
        }
        ?>
      
    </form>

    <p>У разі виникнення проблем зверніться до <a href="#">документації</a>.</p>

</div>


<?php include('base/footer.php'); ?>