<?php
require_once ".\connectMysql\mysqlMain.php";


// Sử dụng class Database
header('Content-Type: application/json');
$host = '192.168.1.102:8306';
$dbname = 'tiendata';
$username = 'root';
$password = 'root';
//connect
$database = new Database($host, $dbname, $username, $password);
$pdo = $database->getPdo();

// Bây giờ bạn có thể sử dụng $pdo để thao tác với cơ sở dữ liệu
