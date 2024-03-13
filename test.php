<?php
function limitPermition1($username, $api)
{
    global $pdo;
    $sql = "SELECT user_login.id, user_login.username , roles.role, roles.name_role FROM user_login inner JOIN user_role ON user_login.id = user_role.user_id inner JOIN roles ON roles.id= user_role.role_id where user_login.username ='$username' and  roles.role= '$api'";
    $result = $pdo->query($sql);
    $result = $result->fetch(PDO::FETCH_ASSOC);
    // dd($api);
    dd($result);
    return $result;
    // echo "1";
}
limitPermition1("tien_de8v", "");
