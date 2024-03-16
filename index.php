<?php
// error_reporting(E_ERROR | E_PARSE);

// FOR DEV_TIEN
// require_once '.\connectMysql\Dev_Tien.php';
//FOR DEV_TUNG
require_once './connectMysql/Dev_Tung.php';

//MAIN:

require_once "./debug.php";
require_once "./authen_author.php";
require_once "./modules/shoe/shoe_manage.php";
require_once "./modules/car/car_manage.php";
require_once "./modules/role/role_manage.php";
require_once './Utils.php';
require_once './api_config.php';
