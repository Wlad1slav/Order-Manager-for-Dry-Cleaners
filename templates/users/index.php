<?php
global $DIR;
include("$DIR/templates/base/include.php");

$pageTitle = "Користувачі";
include("$DIR/templates/base/header.php");
include("$DIR/templates/base/sidebar.php");
?>

<h1><?php echo $pageTitle?></h1>

<?php include 'create.php' ?>

<?php // Обробчик помилок, що можуть виникнути при створенні користувача
if (isset($_SESSION['error'])) {
    echo "<div class='error-message'>";

    echo '<h3>ERROR</h3>';
    echo '<p>' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);

    echo '</div>';
}
?>

<?php include 'table.php' ?> <!--Таблиця користувачів-->

<?php include("$DIR/templates/base/footer.php"); ?>
