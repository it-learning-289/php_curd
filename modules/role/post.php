<?php

// function getRoles() {
    global $pdo;
    $sql = "SELECT username, `role` FROM user_login";
    $result = $pdo->query($sql);
    $result = $result->fetchAll(PDO::FETCH_ASSOC);
    $arrAuthPermit = [];
    foreach ($result as $value) {
        // d($result[$key]["username"]);
        // d($result[$key]["role"]);
        $arrAuthPermit[$value["username"]] = explode(",", $value["role"]);
    }
    // dd($arrAuthPermit);
    echo json_encode($arrAuthPermit);
// }