<?php
error_reporting(E_ERROR | E_PARSE);


// var_dump($pdo);

require_once "./debug.php";
$serverName = $_SERVER['SERVER_NAME'];

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');


$host = $_ENV['DB_HOST'];
$database = $_ENV['DB_DATABASE'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
// dd($port);
// Now you can use these variables to connect to the database
// Example using PDO:
try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
    
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

//  dd("Server Name: " . $serverName);
// require_once "./connectMysql/Dev_Tien.php";
// require_once "./connectMysql/Dev_Tung.php";
// require_once 'vendor/autoload.php';
