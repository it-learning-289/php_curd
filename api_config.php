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
    "/roles/get_role_users/get" =>  ["path" => "./modules/role/get_role_users.php@a"],
    "/roles/get" =>  ["path" => "./modules/role/getRole.php@a"]
];
$method = strtolower($_SERVER['REQUEST_METHOD']);
// dd($method);
$request = explode("/", $_SERVER["PATH_INFO"]);
// dd($request[3]);
foreach ($apiMap as $key => $value) {
    //   d( explode("/", $key)[1] ." " .explode("/", $key)[2]);
    // d(explode("/", $key)[3]);
    if (($request[2] === explode("/", $key)[1]) && ($method === explode("/", $key)[2])) {
        // dd(explode("/", "get_user_roles"));
        // dd(explode("@", $value["path"])); 
        $temp = explode("@", $value["path"])[0];
        if ($value["checkAuthen"] === false) {
            require_once $temp;
            exit;
        } else {
            checkAuthForApi();
<<<<<<< HEAD
            // dd($key);
            $author = new Author($key);
            list($decoded_username, $decoded_password) = getUsernamePassFromToken();
            if (!$author->checkPermission($decoded_username)) {
                echo json_encode(array("message" => "not allow"));
                exit;
            }

            // $decoded_username = getUsernamePassFromToken()[0];

=======
            // $decoded_username = getUsernamePassFromToken()[0];
            list($decoded_username, $decoded_password) = getUsernamePassFromToken();
            
            //TEST
            // Create an instance of Authen
            $authen = new Authen($decoded_username, $decoded_password);
            if ($authen->authenticate()) {
                echo "Authentication successful.<br>";
            
                // Create an instance of Author
                $author = new Author('admin');
            
                // Check permission
                if ($author->checkPermission($key)) {
                    echo "Authorization granted for admin role.<br>";
                } else {
                    echo "Authorization denied for admin role.<br>";
                    exit;
                }
            } else {
                echo "Authentication failed.<br>";
                exit;
            }

>>>>>>> 9a1db96 (dev_tien testing class author)
            // if (!limitPermition($decoded_username, $key)) {
            //     echo json_encode(array("message" => "not allow"));
            //     exit;
            // }
<<<<<<< HEAD
            // dd($temp);
=======

>>>>>>> 9a1db96 (dev_tien testing class author)
            require_once $temp;
            exit;

        }
    } else  if (($request[2] === explode("/", $key)[1]) && ($method === explode("/", $key)[3])) {
        // dd(explode("@", $value["path"])); 
        // dd(explode("/", $key)[2]);
        $arrGetRole_User = ["get_user_roles", "get_role_users"];
        // dd($request[3]);
        if (in_array($request[3], $arrGetRole_User)) {
            // checkAuthForApi();
            // $decoded_username = getUsernamePassFromToken()[0];
            // if (!limitPermition($decoded_username, $key)) {
            //     echo json_encode(array("message" => "not allow"));
            //     exit;
            // }
            checkAuthForApi();
            // dd($key);
            $author = new Author($key);
            list($decoded_username, $decoded_password) = getUsernamePassFromToken();
            if (!$author->checkPermission($decoded_username)) {
                echo json_encode(array("message" => "not allow"));
                exit;
            }
            $temp = "./modules/role/" . $request[3] . ".php";
            // dd($temp);
            require_once $temp;
            exit;
        } else {
            $temp = explode("@", $value["path"])[0];
            // checkAuthForApi();
            // $decoded_username = getUsernamePassFromToken()[0];
            // if (!limitPermition($decoded_username, $key)) {
            //     // dd($key);
            //     echo json_encode(array("message" => "not allow"));
            //     exit;
            // }
            checkAuthForApi();
            // dd($key);
            $author = new Author($key);
            list($decoded_username, $decoded_password) = getUsernamePassFromToken();
            if (!$author->checkPermission($decoded_username)) {
                echo json_encode(array("message" => "not allow"));
                exit;
            }
            // dd($temp);
            require_once $temp;
            exit;
        }
    }
}

die();
