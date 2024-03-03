<?php

// var_dump($module1);
// die();

function checkModuleExits($x, $array)
{
    if (in_array($x, $array)) {
        return true;
    }
    return false;
}
function limitPermition($username,$api)
{
    global $pdo;
    $sql = "SELECT user_login.id, user_login.username , roles.role, roles.name_role FROM user_login inner JOIN user_role ON user_login.id = user_role.user_id inner JOIN roles ON roles.id= user_role.role_id where user_login.username ='$username' and  roles.role= '$api'";
    $result = $pdo->query($sql);
    $result = $result->fetch(PDO::FETCH_ASSOC);
    // dd($api);
    return $result;
}

function getUsernamePassFromToken()
{
    $tungtvAuthTokenDecode = base64_decode($_SERVER["HTTP_TUNGTV_AUTHEN_TOKEN"]);
    // dd($tungtvAuthTokenDecode);
    // dd(base64_decode("dGllbl9kZXZ2OmFzZmRzZ3NkZmho"));
    return explode(':', $tungtvAuthTokenDecode);
}
function checkAuthForApi()
{
    global $pdo;
    if (array_key_exists("HTTP_TUNGTV_AUTHEN_TOKEN", $_SERVER)) {
        // $tungtvAuthTokenDecode = base64_decode($_SERVER["HTTP_TUNGTV_AUTHEN_TOKEN"]);
        // list($decoded_username, $decoded_password) = explode(':', $tungtvAuthTokenDecode);
        // dd(base64_decode("dGllbl9kZXZ2OmFzZmRzZ3NkZmho"));
        // dd($_SERVER["HTTP_TUNGTV_AUTHEN_TOKEN"]);
        list($decoded_username, $decoded_password) = getUsernamePassFromToken();
        // dd($decoded_password);
        // dd(getUsernamePassFromToken());
        $sqlId = "SELECT username, `password` FROM user_login WHERE username = '$decoded_username'";
        $resultId = $pdo->query($sqlId);
        $result = $resultId->fetchAll(PDO::FETCH_ASSOC);
        if (!(count($result) == 1 && $result[0]['password'] == $decoded_password)) {
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
function getModuleFromApi()
{
    return explode("/", $_SERVER["PATH_INFO"])[2];
}

function requireFileByHttpPathInfo($method)
{
    $rs = "";
    $module = getModuleFromApi();
    $moduleDir = getModuleIfExists($module);
    if (is_null($moduleDir)) {
        $rs = $module . ".php";
    } else {
        $rs = "./modules/" . $moduleDir . "/" . strtolower($method) . ".php";
    }
    $arrApiCheckAuth = ["get_token_auth", "register"];
    if (!in_array($module, $arrApiCheckAuth)) {
        // checkAuthForApi();
        // $decoded_username = getUsernamePassFromToken()[0];
        // if (!limitPermition($decoded_username, $module)) {
        //     echo json_encode(array("message" => "not allow"));
        //     exit;
        // }
    }

    return $rs;
}

function getModuleIfExists($moduleName)
{
    foreach (listSubDir('./modules') as $subDir) {
        if ($subDir . "s" === $moduleName) {
            // dd($subDir);
            return $subDir;
        }
    }
    return null;
}

function listSubDir($dir)
{
    $rs = array();
    $subdirs = array_filter(glob($dir . '/*'), 'is_dir');
    // dd($subdirs["1"]);
    $moduleFromApi = getModuleFromApi();
    // dd($arrModule);
    $arrModule = array();
    foreach ($subdirs as $subdir) {
        $item =  explode("/", $subdir);
        $arrModule[] = $item[2];
        // d($item[2]);
        $rs[] = str_replace($dir . "/", "", $subdir);
    }
    // d(substr($moduleFromApi, 0, strlen($moduleFromApi) - 1));
    if (!checkModuleExits(substr($moduleFromApi, 0, strlen($moduleFromApi) - 1), $arrModule)) {
        echo json_encode(array("message" => "api is invalid"));
        exit;
    }
    // die();
    return $rs;
}
// ./modules/test
// listSubDir('./modules/test');
// var_dump(substr($module1, 0, strlen($module1) - 1));

// var_dump(requireFileByHttpPathInfo("gEt"));

// die();
