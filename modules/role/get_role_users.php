<?php
// dd(1);
if ($_GET['page'] != "" && $_GET['limit'] != "") {
    // dd("asdfs");
    $sql = "SELECT roles.id as role_id, roles.role , user_login.username , roles.name_role FROM roles LEFT JOIN user_role  ON roles.id = user_role.role_id LEFT  JOIN user_login  ON user_login.id= user_role.user_id ";
    $result = $pdo->query($sql);
    $result = $result->fetchAll(PDO::FETCH_ASSOC);
    // dd($result);
    $total_rows = count($result);
    $limit = isset($_GET['limit']) ? $_GET['limit'] : $_GET['limit']; // Number of records per page
    if ($limit > 100) {
        echo json_encode(array("message" => "exceed the allowed with limit<=100"));
        exit;
    }
    if ($limit > $total_rows) {
        echo  json_encode(array("message" => "over total records"));
        exit;
    }
    $total_pages = ceil($total_rows / $limit);
    if ($_GET['page'] > $total_pages) {
        echo json_encode(array("message" => "this page invalid"));
        exit;
    }
    // Get page numfber from the request, default to page 1
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1) * $limit;

    $stmt = $pdo->prepare("SELECT roles.id as role_id, roles.role , user_login.username , roles.name_role FROM roles LEFT JOIN user_role  ON roles.id = user_role.role_id LEFT  JOIN user_login  ON user_login.id= user_role.user_id LIMIT :start, :limit");
    $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $userRoles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $arrAuthPermit = [];
    foreach ($userRoles as $index => $value) {
        // d($value['role']);
        if (!is_null($value["username"])) {
            $arrAuthPermit[$value["role"]][] =   implode("", explode(",", $value["username"]));
        } else {

            $arrAuthPermit[$value["role"]] = [];
        }
    }
    // $sql = "SELECT username, `role` FROM user_login";
    echo json_encode([
        'page' => $page,
        'total_pages' => $total_pages,
        "total_record" => $total_rows,
        "data" => $arrAuthPermit
    ]);
} else {
    echo json_encode(array("message" => "enter page or limit"));
}
