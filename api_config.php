<?php

function getApiConfig()
{
    return  [
        "/register/post" => [
            "path" => "./register.php@register",
            "checkAuthen" => false
        ],
        "/get_token_auth/post" => [
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
}
