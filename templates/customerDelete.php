<?php
global $DIR;

if (isset($_GET['id']))
    $customerID = intval($_GET['id']); // конвертуємо id в ціле число, щоб запобігти можливим атакам
else
    // Немає id у URL. Обробка помилки.
    die("ID клієнта не вказано!");

include "$DIR/templates/customers.php";
Customer::get($customerID)->delete();
?>
<script src="../static/javascript/utils.js"></script>
<script>
    redirectTo('customers');
</script>
