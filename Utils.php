<?php
// var_dump($module1);
// die();

function requireFileByHttpPathInfo($method)
{
    $rs = "";
    $pathInfoArr = explode("/", $_SERVER["PATH_INFO"]);
    $module = $pathInfoArr[2];
    $moduleDir = getModuleIfExists($module);
    if (is_null($moduleDir)) {
        $rs = $module.".php";
    } else {
        $rs = "./modules/".$moduleDir."/".strtolower($method).".php";
    }
    // var_dump($rs);
    // die();
    return $rs;
}


function getModuleIfExists($moduleName)
{
    foreach (listSubDir('./modules') as $subDir) {
        if($subDir . "s" === $moduleName) {
            return $subDir;
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
