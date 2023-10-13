<?php
session_start();

include '../templates/customers.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $discount = $_POST["discount"];
    $advertisingCompany = $_POST["advertisingCompany"];

    try {
        $customer = Customer::get($id);
        $customer->setFullName($name);
        $customer->setPhoneNumber($phone);
        $customer->setDiscount($discount);
        $customer->setAdvertisingCompany($advertisingCompany);
        $customer->update();
    } catch (Exception $e) {
        $_SESSION['error'] = '<b>Помилка при редагуванні клієнта</b><br>' . $e->getMessage();
    }
}
?>
<script src="../static/javascript/utils.js"></script>
<script>
    redirectTo('/customers');
</script>
