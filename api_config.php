<?php

$apiMap = [
    "/register/@post" => [
        "path" => "./register.php@register",
        "checkAuthen" => false
    ],
    "/get_token_auth/@get" => [
        "path" => "./get_token_auth.php@get_token_auth",
        "checkAuthen" => false
    ],
    "/cars\/(\d.*)/@delete" => ["path" => "./modules/car/delete.php@getTokenAuth"],
    "/cars/@get" =>  ["path" => "./modules/car/get.php@getTokenAuth"],
    "/shoes\/(\d.*)/@delete" => ["path" => "./modules/car/delete.php@getTokenAuth"],
    "/shoes/@get" =>  ["path" => "./modules/shoe/get.php@shoeGet"],
    "/shoes/@post" =>  ["path" => "./modules/shoe/post.php@a"]
];
