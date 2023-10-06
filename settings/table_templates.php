<?php

$config = require 'db_config.php';
$db = $config['dbname'];
return [
    'orders'=>'',
    'users'=>"CREATE TABLE `$db`.`users` (`id` INT NOT NULL AUTO_INCREMENT , `username` VARCHAR(25) NOT NULL , `password` VARCHAR(60) NOT NULL , `id_rights` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;",
    'customers'=>"CREATE TABLE `$db`.`customers` (`full_name` VARCHAR(30) NOT NULL , `phone_number` VARCHAR(20) NOT NULL , `discount` FLOAT(3,1) NOT NULL DEFAULT '0' , `id` INT NOT NULL AUTO_INCREMENT , PRIMARY KEY (`id`)) ENGINE = InnoDB;"
];