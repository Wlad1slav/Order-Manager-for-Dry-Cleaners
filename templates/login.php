<?php
if (!empty($_SESSION['user']['id']))
    Router::redirect('/profile');

include('base/include.php');

$pageTitle = "Увійти";
include('base/header.php');
?>

<style>
    body {
        /*https://www.hdwallpapers.in/download/raccoon_with_stare_look_on_tree_trunk_in_blur_bokeh_background_4k_5k_hd_raccoon-HD.jpg*/
        /*https://wallpaperboat.com/wp-content/uploads/2020/04/funny-raccoon-03.jpg*/
        /*https://cdn.suwalls.com/wallpapers/animals/raccoon-27229-1920x1080.jpg*/
        background-image: url('https://cdn.suwalls.com/wallpapers/animals/raccoon-27229-1920x1080.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
    }
</style>


<div class="container page-center">

    <form method="post" class="login-form">
        <h1>Вітаємо!</h1>
<!--        <h2>Будь ласка, увійдіть, щоб продовжити.</h2>-->



        <div class="input-wrapper">
            <input type="text" name="login" id="login">
            <label for="login">Login</label>
        </div>

        <div class="input-wrapper">
            <input type="password" name="password" id="password">
            <label for="password">Пароль</label>
        </div>

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

        <p>У разі виникнення проблем зверніться до <a href="#">документації</a>.</p>
      
    </form>

</div>



<?php include('base/footer.php'); ?>