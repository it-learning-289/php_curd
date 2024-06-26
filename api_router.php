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
        foreach ($this->apiMap as $key => $value) {

            list($decoded_username, $decoded_password) = ApiHandler::getUsernamePassFromToken();
            if (($request[2] === explode("/", $key)[1]) && ($method === explode("/", $key)[2])) {
                if ($value["checkAuthen"] === false) {
                    $temp = explode("@", $value['path'])[0];
                    // dd($value[`part`]);
                    // dd($temp);
                    require_once $temp;
                    exit;
                } else {

                    ApiHandler::checkAuthForApi();
                    // dd($key);
                    $author = new Author($key);
                    list($path, $class_function)  = explode("@", $value["path"]);
                    // dd(explode("@", $value["path"]));
                    list($class, $nameFunction) = explode("/", $class_function);
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
                // dd($request[2]);
                // dd($method);
                $arrGetRole_User = ["get_user_roles", "get_role_users"];
                $role_get = "/roles/" . $request[3] . "/get";
                $role_user = "/$request[2]/{id}/$method";
                // dd($role_user);
                // dd($role);

                // dd(explode("/", $class_function));
                // dd(explode("/", $key));
                if (in_array($request[3], $arrGetRole_User)) {
                    ApiHandler::checkAuthForApi();
                    // dd($decoded_username);
                    $author = new Author($role_get);
                    list($path, $class_function)  = explode("@", $this->apiMap[$role_get]["path"]);
                    list($class, $nameFunction) = explode("/", $class_function);
                    if (!$author->checkPermission($decoded_username)) {

                        echo json_encode(array("message" => "not allow"));
                        exit;
                    }
                    // dd($nameFunction);
                    call_user_func(array(new $class($this->pdo), $nameFunction));
                    exit;
                } else {
                    ApiHandler::checkAuthForApi();
                    // dd($decoded_username);
                    $author = new Author($role_user);
                    list($path, $class_function)  = explode("@", $this->apiMap[$role_user]["path"]);
                    list($class, $nameFunction) = explode("/", $class_function);
                    if (!$author->checkPermission($decoded_username)) {
                        // dd($decoded_password);
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
