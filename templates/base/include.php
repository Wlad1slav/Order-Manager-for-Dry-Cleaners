<?php
require_once 'styles.php';

$config = require_once "D:\DEV\Ampps\www\settings\config.php";
global $DIR;
$DIR = $config['ROOT_FOLDER'];

global $router;
$sidebar = require_once "$DIR\settings\sidebar_rows.php";

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