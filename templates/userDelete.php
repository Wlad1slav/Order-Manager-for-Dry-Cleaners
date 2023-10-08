<?php
global $DIR;

if (isset($_GET['id']))
    $userID = intval($_GET['id']); // конвертуємо id в ціле число, щоб запобігти можливим атакам
else
    // Немає id у URL. Обробка помилки.
    die("ID користувача не вказано!");

include "$DIR/templates/users.php";
User::get($userID)->delete();
?>
<script src="../static/javascript/utils.js"></script>
<script>
    redirectTo('/users');
</script>
