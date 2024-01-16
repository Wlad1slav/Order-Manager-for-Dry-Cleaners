<?php
require_once 'styles.php';

$config = require_once "settings/config.php";
global $DIR;

global $router;
$sidebar = require_once "sidebar.php";

require_once "$DIR\Repository.php";
require_once "$DIR\RepositoryTraits.php";

require_once "$DIR\Utils.php";

require_once "$DIR\Goods.php";
require_once "$DIR\Rights.php";
require_once "$DIR\User.php";
require_once "$DIR\Customer.php";
require_once "$DIR\Product.php";
require_once "$DIR\Order.php";
require_once "$DIR\ProductAdditionalFields.php";
require_once "$DIR\Analytic.php";
