<?php
class ApiRouter
{
    private $apiMap;
    private $pdo;

    public function __construct($apiMap, $pdo)
    {
        $this->apiMap = $apiMap;
        $this->pdo = $pdo;
    }

    public function routeApi()
    {
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        // dd($method);
        $request = explode("/", $_SERVER["PATH_INFO"]);
        // dd($request[2]);
        $apiHandler = new ApiHandler($this->pdo);
        foreach ($this->apiMap as $key => $value) {
            
          
            list($path, $class_function)  = explode("@", $value["path"]);
            list($class, $nameFunction) = explode("/", $class_function);
            list($decoded_username, $decoded_password) = $apiHandler->getUsernamePassFromToken();

            if (($request[2] === explode("/", $key)[1]) && ($method === explode("/", $key)[2])) {
                if ($value["checkAuthen"] === false) {
                   
                    $temp = explode("@", $value['path'])[0];
                    // dd($temp);
                    require_once $temp;
                    exit;
                } else {
                    $apiHandler->checkAuthForApi();
                    $author = new Author($key);
                    if (!$author->checkPermission($decoded_username)) {
                        echo json_encode(array("message" => "not allow"));
                        exit;
                    }
                    // dd($temp);       
                    // dd($class);             
                    call_user_func(array(new $class($this->pdo), $nameFunction));
                    // echo $result;

                    exit;
                }
            } else if (($request[2] === explode("/", $key)[1]) && ($method === explode("/", $key)[3])) {
                // dd($request[3]);
                $arrGetRole_User = ["get_user_roles", "get_role_users"];
                $role = "/roles/" .$request[3]."/get";
                $author = new Author($role);
                // dd(explode("/", $key));
                if (in_array($request[3], $arrGetRole_User)) {
                    $apiHandler->checkAuthForApi();
                    // dd($decoded_username);
                   
                    if (!$author->checkPermission($decoded_username)) {
                       
                        echo json_encode(array("message" => "not allow"));
                        exit;
                    }
                    // $temp = "./modules/role/" . $request[3] . ".php";
                    // require_once $temp;
                    call_user_func(array(new $class($this->pdo), $nameFunction));
                    exit;
                } else {
                    $apiHandler->checkAuthForApi();
                    // dd($decoded_username);

                    if (!$author->checkPermission($decoded_username)) {

                  
                        echo json_encode(array("message" => "not allow"));
                        exit;
                    }
                    call_user_func(array(new $class($this->pdo), $nameFunction));
                    exit;
                }
            }
        }
    }
}

// global $pdo;
$apiMap = [
    "/register/post" => [
        "path" => "./register.php@register",
        "checkAuthen" => false
    ],
    "/get_token_auth/get" => [
        "path" => "./get_token_auth.php@gettokenauth",
        "checkAuthen" => false
    ],
    "/cars/{id}/delete" => ["path" => "./modules/car/car_manage.php@CarsManager/delCar"],
    "/cars/get" =>  ["path" => "./modules/car/car_manage.php@CarsManager/getCars"],
    "/cars/post" =>  ["path" =>  "./modules/car/car_manage.php@CarsManager/postCar"],

    "/shoes/{id}/delete" => ["path" => "./modules/shoe/shoe_manage.php@ShoesManager/delShoe"],
    "/shoes/get" =>  ["path" => "./modules/shoe/shoe_manage.php@ShoesManager/getShoes"],
    "/shoes/post" =>  ["path" =>  "./modules/shoe/shoe_manage.php@ShoesManager/postShoe"],

    "/roles/post" =>  ["path" =>  "./modules/role/role_manage.php@sRoleManager/postRole"],
    "/roles/get_user_roles/get" =>  ["path" => "./modules/role/role_manage.php@RoleManager/getUserRolesByPage"],
    "/roles/get_role_users/get" =>  ["path" => "./modules/role/role_manage.php@RoleManager/getRoleUsersByPage"]
    

];
// dd("asdv");
$apiRouter = new ApiRouter($apiMap, $pdo);
$apiRouter->routeApi();
