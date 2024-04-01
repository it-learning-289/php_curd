<?php
require_once  "./connectMysql/mysqlMain.php";
use Symfony\Component\Dotenv\Dotenv;
require_once 'vendor/autoload.php';

// Đường dẫn đến file .env (thường là thư mục gốc của ứng dụng)
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/connectMysql/.env');

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