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
    "/shoes\/(\d.*)/delete" => ["path" => "./modules/shoe/delete.php@getTokenAuth"],
    "/shoes/get" =>  ["path" => "./modules/shoe/get.php@shoeGet"],
    "/shoes/post" =>  ["path" => "./modules/shoe/post.php@a"]
];
$method = strtolower($_SERVER['REQUEST_METHOD']);
// dd($method);
$request = explode("/", $_SERVER["PATH_INFO"]);
// dd($request);
// dd(explode("/", "/shoes\/(\d.*)/delete")[1]);
foreach ($apiMap as $key => $value) {
    //   d( explode("/", $key)[1] ." " .explode("/", $key)[3]);
    // d($key);
    if (($request[2] === explode("/", $key)[1]) && ($method === explode("/", $key)[2])) {
        // dd(explode("@", $value["path"])); 
        $temp = explode("@", $value["path"])[0];
        if ($value["checkAuthen"] === false) {
            require_once $temp;
            exit;
        } else {
            checkAuthForApi();
            $decoded_username = getUsernamePassFromToken()[0];
            if (!limitPermition($decoded_username, $key)) {
                echo json_encode(array("message" => "not allow"));
                exit;
            }
            require_once $temp;
            exit;
        }
    } else if (($request[2] === substr(explode("/", $key)[1], 0, -1)) && ($method === explode("/", $key)[3])) {
        // dd(explode("@", $value["path"])); 
        $temp = explode("@", $value["path"])[0];
        checkAuthForApi();
        $decoded_username = getUsernamePassFromToken()[0];
        if (!limitPermition($decoded_username, $key)) {
            echo json_encode(array("message" => "not allow"));
            exit;
        }
        // dd($temp);
        require_once $temp;
        exit;
    }
}
// die();