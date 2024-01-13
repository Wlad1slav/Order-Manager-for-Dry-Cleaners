<?php
require_once 'Customer.php';

global $DIR;
include("$DIR/templates/base/include.php");

$pageTitle = "Dashboard";
include("$DIR/templates/base/header.php");
include("$DIR/templates/base/sidebar.php");

global $router;

$analytic = new Analytic();
$orders = $analytic->get();
?>

<h1><?php echo $pageTitle ?></h1>

<div class="dashboard-tables">
    <div>
        <h2>Нові замовлення</h2>
        <?php
        if (isset($orders['Today']['date_create']['orders']))
            include('todayCreatedOrders.php');
        else echo '<i>Поки що немає...</i>'
        ?>
    </div>

    <div>
        <h2>Оплачені замовлення</h2>
        <?php
        if (isset($orders['Today']['date_payment']['orders']))
            include('todayPaidOrders.php');
        else echo '<i>Поки що немає...</i>'
        ?>
    </div>
</div>


<?php include("$DIR/templates/base/footer.php"); ?>
