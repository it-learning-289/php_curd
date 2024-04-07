<?php
require_once  "./connectMysql/mysqlMain.php";

require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'./connectMysql/.env');


// Sử dụng các biến môi trường
$dbHost = $_ENV['DEV_TUNG'];
dd($dbHost);
// MySQL server details
header('Content-Type: application/json');
$host = '10.110.69.10:8806';
$dbname = 'tiendata';
$username = 'root';
$password = 'root';
//connect
$database = new Database($host, $dbname, $username, $password);
$pdo = $database->getPdo();