<?php
error_reporting(E_ERROR | E_PARSE);

/** FOR DEV_TIEN */
header('Content-Type: application/json');
$host = '192.168.1.103:8306';
$dbname = 'tiendata';
$username = 'root';
$password = 'root';

try {

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

/*FOR DEV_TUNG */
// MySQL server details
// header('Content-Type: application/json');
// $host = '10.110.69.10';
// $port = 8806;
// $dbname = 'tiendata';
// $username = 'root';
// $password = 'root';

// // PDO connection string
// $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';port=' . $port;

// try {
//     // Create a PDO instance
//     $pdo = new PDO($dsn, $username, $password);
//     // Now you can use $pdo for your database operations
//     // echo "Connection ok";
// } catch (PDOException $e) {
//     // Handle connection errors
//     echo "Connection failed: " . $e->getMessage();
// }

// // Kiểm tra phương thức HTTP
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        require_once 'shoe/get.php';
        break;
    case 'POST':
        require_once 'shoe/post.php';
        break;
    case 'DELETE':
        require_once
        break;
}

            // case 'DELETE':
           
            // break;

            // case 'PUT':
            
            // break;