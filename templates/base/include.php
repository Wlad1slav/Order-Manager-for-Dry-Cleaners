<?php
include 'styles.php';

$config = require "D:\DEV\Ampps\www\settings\config.php";
global $DIR;
$DIR = $config['ROOT_FOLDER'];


$sidebar = require "$DIR\settings\sidebar_rows.php";

include "$DIR\Repository.php";
include "$DIR\RepositoryTraits.php";

include "$DIR\Utils.php";

include "$DIR\Goods.php";
include "$DIR\Rights.php";
include "$DIR\User.php";
include "$DIR\Customer.php";
include "$DIR\Product.php";
include "$DIR\Order.php";