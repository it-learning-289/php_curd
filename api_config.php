<?php
// require_once("./auth.php");
$apiMap = [
    "/register/post" => [   //  --> /feature/method
        "path" => "./register.php@register",
        "checkAuthen" => false
    ],
    "/get_token_auth/get" => [
        "path" => "./get_token_auth.php@gettokenauth",
        "checkAuthen" => false
    ],
    "/cars\/(\d.*)/delete" => ["path" => "./modules/car/delete.php@getTokenAuth"],
    "/cars/get" =>  ["path" => "./modules/car/get.php@getTokenAuth"],
    "/shoes\/(\d.*)/delete" => ["path" => "./modules/car/delete.php@getTokenAuth"],
    "/shoes/get" =>  ["path" => "./modules/shoe/get.php@shoeGet"],
    "/shoes/post" =>  ["path" => "./modules/shoe/post.php@a"]
];
$method = strtolower($_SERVER['REQUEST_METHOD']);
$request = explode("/",$_SERVER[ "PATH_INFO"]);
// dd($request);
foreach($apiMap as $key=>$value){
//   d( explode("/", $key)[1]);
if (($request[2] === explode("/", $key)[1])&&($method===explode("/", $key)[2])) {
        // dd(explode("@", $value["path"])); 
        $temp = explode("@", $value["path"])[0];

        // dd($temp);
        require_once $temp;
        die();
        // explode("@",$temp)[1]();

}


}
// die();