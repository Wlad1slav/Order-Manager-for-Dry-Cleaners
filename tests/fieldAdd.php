<?php
require_once 'ProductAdditionalFields.php';
$additionalFields = new ProductAdditionalFields();

$additionalFields->addField(
    'колір',
    ProductAdditionalFields::TYPES[3],
    'білий',
    ['білий', 'жовтий', 'синій']
);

$additionalFields->addField(
    'розмір',
    ProductAdditionalFields::TYPES[0],
    '',
    ['X', 'XL', 'XLL']
);

$additionalFields->save();