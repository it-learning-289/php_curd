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
require_once '.\connectMysql\Dev_Tien.php';
//FOR DEV_TUNG
// require_once '.\connectMysql\Dev_Tung.php';
//MAIN:
// require_once("./import.php");
require_once './Utils.php';
require_once './api_config.php';
// require_once '/Users/trantung/tien_dev/php_curd/modules/export_import/export.php';
// require_once './export.php';
// export("shoes");
// require_once "./import.php";
// export("shoes");
// die();
