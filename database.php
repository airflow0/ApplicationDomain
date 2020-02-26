<?php

define('DB_USER', 'root');
define('DB_PASSWORD', 'ksupassword1');
define('HOST', 'localhost');
define('DB', 'domainproject');

$options = array (
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
);

$pdo = new PDO(
    "mysql:host=" .HOST. "; dbname=".DB, DB_USER, DB_PASSWORD, $options
);

session_start();
$_SESSION['counter'] = 0;

?>