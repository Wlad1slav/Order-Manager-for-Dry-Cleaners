<?php

$config = require 'db_config.php';
$db = $config['dbname'];
return [
    'orders'=>"CREATE TABLE $db.`orders` (`id` INT NOT NULL AUTO_INCREMENT , `id_customer` INT NOT NULL , `id_user` INT NOT NULL , `date_create` DATETIME NOT NULL , `date_end` DATE NOT NULL , `total_price` INT NOT NULL , `productions` JSON NULL , `is_paid` BOOLEAN NOT NULL DEFAULT FALSE , `is_completed` BOOLEAN NOT NULL DEFAULT FALSE , `date_payment` DATE NULL , `date_closing` DATE NULL , `date_last_update` DATE NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;",
    'users'=>"CREATE TABLE `$db`.`users` (`id` INT NOT NULL AUTO_INCREMENT , `username` VARCHAR(255) NOT NULL , `password` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , `id_rights` INT NOT NULL , PRIMARY KEY (`id`), UNIQUE `username` (`username`)) ENGINE = InnoDB;",
    'customers'=>"CREATE TABLE `$db`.`customers` (`id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(30) NOT NULL , `phone` VARCHAR(20) NULL , `discount` FLOAT(3,1) NOT NULL DEFAULT '0' , `advertising_company` VARCHAR(200) NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;"
];