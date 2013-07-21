<?php
// Here you can initialize variables that will for your tests

$dbh = new PDO(
    'mysql:host=localhost;dbname=home_incity_test',
    'root',
    '46820',
    array(PDO::ATTR_PERSISTENT => false)
);
\Codeception\Module\Dbh::$dbh = $dbh;