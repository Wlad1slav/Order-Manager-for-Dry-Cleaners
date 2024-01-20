<?php
require_once 'Repository.php';

$db_config = json_decode(file_get_contents(Repository::CONFIG_PATH), true) ?? [];
$db = $db_config['dbname'];
return [
    'orders'=>"CREATE TABLE $db.`orders` (`id` INT NOT NULL AUTO_INCREMENT , `id_customer` INT NOT NULL , `id_user` INT NOT NULL , `date_create` DATETIME NOT NULL , `date_end` DATE NOT NULL , `total_price` INT NOT NULL , `productions` JSON NULL , `is_paid` BOOLEAN NOT NULL DEFAULT FALSE, `type_of_payment` VARCHAR(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL DEFAULT NULL , `is_completed` BOOLEAN NOT NULL DEFAULT FALSE , `date_payment` DATE NULL , `date_closing` DATE NULL , `date_last_update` DATE NULL , `settings` JSON NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_bin;",
    'users'=>"CREATE TABLE `$db`.`users` (`id` INT NOT NULL AUTO_INCREMENT , `username` VARCHAR(255) NOT NULL , `password` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , `rights` VARCHAR(255) DEFAULT 'default' , PRIMARY KEY (`id`), UNIQUE `username` (`username`)) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_bin;",
    'customers'=>"CREATE TABLE `$db`.`customers` (`id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL , `phone` VARCHAR(20) NULL , `discount` FLOAT(3,1) NOT NULL DEFAULT '0' , `advertising_company` VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_bin;"
];