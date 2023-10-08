<?php
include '../templates/users.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $rights = require '../settings/rights_list.php';
    $right = $rights[$_POST["rights"]-1];

    $user = new User($username, $password, $right);
    $user->save();
}
?>
<script src="../static/javascript/utils.js"></script>
<script>
    redirectTo('/users');
</script>
