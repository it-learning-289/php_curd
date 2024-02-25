<?php
// var_dump($module1);
// die();

function requireFileByHttpPathInfo($method)
{
    global $pdo;
    $rs = "";
    $pathInfoArr = explode("/", $_SERVER["PATH_INFO"]);
    $module = $pathInfoArr[2];
    $moduleDir = getModuleIfExists($module);
    if (is_null($moduleDir)) {
        $rs = $module . ".php";
    } else {
        $rs = "./modules/" . $moduleDir . "/" . strtolower($method) . ".php";
    }
    if (!($module === "get_token_auth")) {
        if (array_key_exists("HTTP_TUNGTV_AUTHEN_TOKEN", $_SERVER)) {
            $tungtvAuthTokenDecode = base64_decode($_SERVER["HTTP_TUNGTV_AUTHEN_TOKEN"]);
            list($decoded_username, $decoded_password) = explode(':', $tungtvAuthTokenDecode);

            $sqlId = "SELECT username, `password` FROM user_login WHERE username = '$decoded_username'";
            $resultId = $pdo->query($sqlId);
            $result = $resultId->fetchAll(PDO::FETCH_ASSOC);

            if (!(count($result) == 1 && $result[0]['password'] == $decoded_password)) {
                header("HTTP/1.1 401 Unauthorized");
                echo "Authorized Failed";
                exit;
            }
        } else {
            header("HTTP/1.1 401 Unauthorized");
            echo "Unauthorized";
            exit;
        }
    }
    return $rs;
}


function getModuleIfExists($moduleName)
{
    foreach (listSubDir('./modules') as $subDir) {
        if ($subDir . "s" === $moduleName) {
            return $subDir."s";
        }
    }
    return null;
}

function listSubDir($dir)
{
    $rs = array();
    $subdirs = array_filter(glob($dir . '/*'), 'is_dir');
    foreach ($subdirs as $subdir) {
        $rs[] = str_replace($dir . "/", "", $subdir);
    }
    return $rs;
}

// var_dump(substr($module1, 0, strlen($module1) - 1));

// var_dump(requireFileByHttpPathInfo("gEt"));

// die();
