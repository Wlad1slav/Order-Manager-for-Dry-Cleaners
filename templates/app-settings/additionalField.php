<?php
if (!isset($router))
    global $router;
?>
<h3>Додаткові поля замовлення</h3>

<?php
// Якщо таблиця додаткових полів не пуста, то йдеться виклик її тегу
$fieldsArray = new ProductAdditionalFields();

if (count($fieldsArray->getFields()) > 0)
    include "additionalFieldTableTag.php"

?>

<?php include 'additionalFieldCreate.php'; ?> <!-- Форма створення нового поля замовлення -->
