<?php
require_once "./authen_author.php";

class ApiHandler {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function checkModuleExists($x, $array) {
        if (in_array($x, $array)) {
            return true;
        }
        return false;
    }

    public function limitPermission($username, $api) {
        $sql = "SELECT user_login.id, user_login.username , roles.role, roles.name_role FROM user_login inner JOIN user_role ON user_login.id = user_role.user_id inner JOIN roles ON roles.id= user_role.role_id where user_login.username ='$username' and  roles.role= '$api'";
        $result = $this->pdo->query($sql);
        $result = $result->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUsernamePassFromToken() {
        $tungtvAuthTokenDecode = base64_decode($_SERVER["HTTP_TUNGTV_AUTHEN_TOKEN"]);
        return explode(':', $tungtvAuthTokenDecode);
    }

    public function checkAuthForApi() {
        if (array_key_exists("HTTP_TUNGTV_AUTHEN_TOKEN", $_SERVER)) {
            list($decoded_username, $decoded_password) = $this->getUsernamePassFromToken();
            $authen = new Authen($decoded_username, $decoded_password);
            // Authenticate the user
            if (!$authen->authenticate()) {
                header("HTTP/1.1 401 Unauthen");
                echo json_encode(array("message" => "Authen Failed"));
                exit;
            }
        } else {
            header("HTTP/1.1 401 Unauthen");
            echo json_encode(array("message" => "Unauthen"));
            exit;
        }
    }

    public function getModuleFromApi() {
        return explode("/", $_SERVER["PATH_INFO"])[2];
    }

    public function requireFileByHttpPathInfo($method) {
        $rs = "";
        $module = $this->getModuleFromApi();
        $moduleDir = $this->getModuleIfExists($module);
        if (is_null($moduleDir)) {
            $rs = $module . ".php";
        } else {
            $rs = "./modules/" . $moduleDir . "/" . strtolower($method) . ".php";
        }
        $arrApiCheckAuth = ["get_token_auth", "register"];
        if (!in_array($module, $arrApiCheckAuth)) {
            // $decoded_username = $this->getUsernamePassFromToken()[0];
            // if (!$this->limitPermission($decoded_username, $module)) {
            //     echo json_encode(array("message" => "not allow"));
            //     exit;
            // }
        }

        return $rs;
    }

    public function getModuleIfExists($moduleName) {
        $rs = array();
        $subdirs = array_filter(glob('./modules/*'), 'is_dir');
        $arrModule = array();
        foreach ($subdirs as $subdir) {
            $item =  explode("/", $subdir);
            $arrModule[] = $item[2];
            $rs[] = str_replace('./modules/', "", $subdir);
        }
        if (!$this->checkModuleExists($moduleName, $arrModule)) {
            echo json_encode(array("message" => "api is invalid"));
            exit;
        }
        return $rs;
    }
}

// Sử dụng class ApiHandler
require_once "./connectMysql/Dev_Tien.php"; // Include file chứa kết nối PDO

$apiHandler = new ApiHandler($pdo);
// $apiHandler->requireFileByHttpPathInfo("get");
?>
