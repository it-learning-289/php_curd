<?php
require_once  "./connectMysql/mysqlMain.php";
// MySQL server details
header('Content-Type: application/json');
$host = '10.110.69.10:8806';
// $port = 8806;
$dbname = 'tiendata';
$username = 'root';
$password = 'root';
//connect
$database = new Database($host, $dbname, $username, $password);
$pdo = $database->getPdo();
