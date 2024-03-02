<?php
error_reporting(E_ERROR | E_PARSE);

//DEBUG
function dd($var)
{
    var_dump($var);
    die;
}

function d($var)
{
    var_dump($var);
}
// FOR DEV_TIEN
// require_once './Dev_Tien.php';

//FOR DEV_TUNG
require_once'./Dev_Tung.php';

// // Kiểm tra phương thức HTTP
// var_dump($_SERVER);
// die();

require_once './Utils.php';
require_once './api_config.php';
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

        // case 'PUT':

        // break;
// }
