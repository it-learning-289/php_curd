<?php

// $apiMap = [
//     "register" => "./auth.php@register",
//     "get_token_auth" => "./auth.php@getTokenAuth",
// ];

// list($filePath, $functionName) = explode("@", $apiMap["get_token_auth"]);

// // var_dump($filePath);
// require_once $filePath;
// $functionName();
$string = "name,age,áv";
$arr = explode(",",$string);
var_dump($arr[0]);
?>