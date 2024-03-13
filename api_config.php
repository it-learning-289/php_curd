<?php
class ApiRouter {
    private $apiMap;
    private $pdo;

    public function __construct($apiMap, $pdo) {
        $this->apiMap = $apiMap;
        $this->pdo = $pdo;
    }

    public function routeApi() {
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $request = explode("/", $_SERVER["PATH_INFO"]);
        $apiHandler = new ApiHandler($this->pdo);

        foreach ($this->apiMap as $key => $value) {
            $author = new Author($key);

            if (($request[2] === explode("/", $key)[1]) && ($method === explode("/", $key)[2])) {
                $temp = explode("@", $value["path"])[0];
                if ($value["checkAuthen"] === false) {
                    require_once $temp;
                    exit;
                } else {
                    $apiHandler->checkAuthForApi();
                    list($decoded_username, $decoded_password) = $apiHandler->getUsernamePassFromToken();
                    if (!$author->checkPermission($decoded_username)) {
                        echo json_encode(array("message" => "not allow"));
                        exit;
                    }
                    require_once $temp;
                    exit;
                }
            } else if (($request[2] === explode("/", $key)[1]) && ($method === explode("/", $key)[3])) {
                $arrGetRole_User = ["get_user_roles", "get_role_users"];
                if (in_array($request[3], $arrGetRole_User)) {
                    $apiHandler->checkAuthForApi();
                    list($decoded_username, $decoded_password) = $apiHandler->getUsernamePassFromToken();
                    if (!$author->checkPermission($decoded_username)) {
                        echo json_encode(array("message" => "not allow"));
                        exit;
                    }
                    $temp = "./modules/role/" . $request[3] . ".php";
                    require_once $temp;
                    exit;
                } else {
                    $temp = explode("@", $value["path"])[0];
                    $apiHandler->checkAuthForApi();
                    list($decoded_username, $decoded_password) = $apiHandler->getUsernamePassFromToken();
                    if (!$author->checkPermission($decoded_username)) {
                        echo json_encode(array("message" => "not allow"));
                        exit;
                    }
                    require_once $temp;
                    exit;
                }
            }
        }
    }
}

// Sử dụng class ApiRouter
require_once "./Dev_Tien.php"; // Include file chứa kết nối PDO

$apiMap = [
    "/register/post" => [
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

$apiRouter = new ApiRouter($apiMap, $pdo);
$apiRouter->routeApi();
?>
