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
    "/cars/{id}/delete" => ["path" => "./modules/car/delete.php@getTokenAuth"],
    "/cars/get" =>  ["path" => "./modules/car/get.php@getTokenAuth"],
    "/cars/{id}/patch" =>  ["path" => "./modules/car/patch.php@getTokenAuth"],
    "/cars/{id}/put" =>  ["path" => "./modules/car/put.php@getTokenAuth"],
    "/shoes/{id}/delete" => ["path" => "./modules/shoe/delete.php@getTokenAuth"],
    "/shoes/get" =>  ["path" => "./modules/shoe/get.php@shoeGet"],
    "/shoes/post" =>  ["path" => "./modules/shoe/post.php@a"],
    "/roles/post" =>  ["path" => "./modules/role/postRole.php@a"],
    "/roles/delete" =>  ["path" => "./modules/role/deleteRole.php@a"],
    "/roles/get_user_roles/get" =>  ["path" => "./modules/role/get_user_roles.php@a"],
    "/roles/get" =>  ["path" => "./modules/role/getRole.php@a"]
];
$method = strtolower($_SERVER['REQUEST_METHOD']);
// dd($method);
$request = explode("/", $_SERVER["PATH_INFO"]);
// dd($request[2]);
// dd(explode("/", "/shoes\/(\d.*)/delete")[1]);
foreach ($apiMap as $key => $value) {
    //   d( explode("/", $key)[1] ." " .explode("/", $key)[2]);
    // d($key);
    //  dd(explode("/", "/cars/{id}/delete"));

    if (($request[2] === explode("/", $key)[1]) && ($method === explode("/", $key)[2])) {
     
        // dd(explode("/", "get_user_roles"));
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
            // exit;
        }
    } else  if (($request[2] === explode("/", $key)[1]) && (($method === explode("/", $key)[3]) || ($method === explode("/", $key)[4]))) {
        // dd(explode("@", $value["path"])); 
        // dd("explode("/", $key)");
        // d($request);
        $temp = explode("@", $value["path"])[0];
        checkAuthForApi();
        $decoded_username = getUsernamePassFromToken()[0];
        if (!limitPermition($decoded_username, $key)) {
            // dd($key);
            echo json_encode(array("message" => "not allow"));
            exit;
        }
        // dd("asdfasf");
        // dd($temp);
        require_once $temp;
        exit;
    }
}

// die();