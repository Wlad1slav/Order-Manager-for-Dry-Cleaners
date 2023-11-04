<?php
include('base/include.php');
global $DIR;

//if (isset($_GET['num']))
//    $errNum = intval($_GET['num']);
//else
//    $errNum = 'НЕВІДОМО';

$pageTitle = "Помилка $errNum";
include('base/header.php');
include('base/sidebar.php');
//echo $DIR . 'static\images\\error.webp';
?>

<div>
    <h2>Упс...</h2>
    <h1>На сторінці сталася помилка <span class="error-num"><?php echo $errNum; ?></span></h1>
    <p>Ймовірно, у вас немає доступу до сторінки, чи її не існує.</p>
    <p>Звернитися до розробника за подробицями.</p>
    <img src="/static/images/raccoon.png" alt="raccoon">
</div>

<?php include('base/footer.php'); ?>
