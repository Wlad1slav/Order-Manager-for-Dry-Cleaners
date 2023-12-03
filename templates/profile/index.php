<?php
global $DIR;
include("$DIR/templates/base/include.php");

global $router;

$pageTitle = "Профіль";
include("$DIR/templates/base/header.php");
include("$DIR/templates/base/sidebar.php");

$user = User::get($_SESSION['user']['id']);
$right = $user->getUserRights();
?>

<?php include 'profileInfo.php' ?> <!-- Інформація про профіль користувача -->

<?php include 'passwordEdit.php' ?> <!--Форма зміни паролю -->

<?php // Обробчик помилок, що можуть виникнути при зміні паролю
if (isset($_SESSION['error'])) {
    echo "<div class='error-message'>";

    echo '<h3>ERROR</h3>';
    echo '<p>' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);

    echo '</div>';
}
?>

<?php include 'permissionsTable.php' ?>

<?php include("$DIR/templates/base/footer.php"); ?>
