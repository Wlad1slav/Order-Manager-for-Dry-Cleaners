<?php

$config = require 'db_config.php';
$db = $config['dbname'];
return [
    'orders'=>'',
    'users'=>"CREATE TABLE `$db`.`users` (`id` INT NOT NULL AUTO_INCREMENT , `username` VARCHAR(255) NOT NULL , `password` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , `id_rights` INT NOT NULL , PRIMARY KEY (`id`), UNIQUE `username` (`username`)) ENGINE = InnoDB;",
    'customers'=>"CREATE TABLE `$db`.`customers` (`id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(30) NOT NULL , `phone` VARCHAR(20) NULL , `discount` FLOAT(3,1) NOT NULL DEFAULT '0' , `advertising_company` VARCHAR(200) NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;"
];