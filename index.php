<?php
error_reporting(E_ERROR | E_PARSE);

//DEBUG
function dd($var)
{
    var_dump($var);
    die;
}
<<<<<<< HEAD

function d($var) {
=======
function d($var)
{
>>>>>>> 6714745 (dev_tien dev_tung)
    var_dump($var);
}
//FOR DEV_TIEN
require_once './Dev_Tien.php';

//FOR DEV_TUNG
// require_once'./Dev_Tung.php';

<<<<<<< HEAD
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

require_once'./Utils.php';
require_once'./api_config.php';
// $method = $_SERVER['REQUEST_METHOD'];
// switch ($method) {
//     case 'GET':
//         require_once requireFileByHttpPathInfo("GET");
//         break;
//     case 'POST':
//         require_once requireFileByHttpPathInfo("POST");
//         break;
//     case 'DELETE':
//         require_once requireFileByHttpPathInfo("DELETE");
//         break;
=======
require_once './Utils.php';
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        require_once requireFileByHttpPathInfo("GET");
        break;
    case 'POST':
        require_once requireFileByHttpPathInfo("POST");
        break;
    case 'DELETE':
        require_once requireFileByHttpPathInfo("DELETE");
        break;
>>>>>>> 6714745 (dev_tien dev_tung)

        // case 'PUT':

        // break;
// }
