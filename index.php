<?php
error_reporting(E_ERROR | E_PARSE);

// /** FOR DEV_TIEN */
// header('Content-Type: application/json');
// $host = '192.168.1.103:8306';
// $dbname = 'tiendata';
// $username = 'root';
// $password = 'root';

// try {

//     $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     die("Connection failed: " . $e->getMessage());
// }

/*FOR DEV_TUNG */
// MySQL server details
header('Content-Type: application/json');
$host = '10.110.69.10';
$port = 8806;
$dbname = 'tiendata';
$username = 'root';
$password = 'root';

// PDO connection string
$dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';port=' . $port;

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $username, $password);
    // Now you can use $pdo for your database operations
    // echo "Connection ok";
} catch (PDOException $e) {
    // Handle connection errors
    echo "Connection failed: " . $e->getMessage();
}

// // Kiểm tra phương thức HTTP
// var_dump($_SERVER);
// die();
$pathInfoArr = explode("/", $_SERVER["PATH_INFO"]);
$module1 = $pathInfoArr[2];
// var_dump($module1);
// die();
// var_dump(str_replace("s", "", $module));
// die();
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        require_once substr($module1, 0, strlen($module1) - 1) . '/get.php';
        break;
    case 'POST':
        require_once substr($module1, 0, strlen($module1) - 1) . '/post.php';
        break;

    case 'DELETE':
        require_once substr($module1, 0, strlen($module1) - 1) . '/delete.php';
        break;

        // case 'PUT':

        // break;
}
