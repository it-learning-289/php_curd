<?php
global $pdo;
if ($_GET['page'] != "") {
    $limit = 10; // Number of records per page
    // Get page numfber from the request, default to page 1
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1) * $limit;

    $sql = "SELECT username, `role` FROM user_login";
    $result = $pdo->query($sql);
    $result = $result->fetchAll(PDO::FETCH_ASSOC);
    $total_rows = count($result);
    $total_pages = ceil($total_rows / $limit);
    $arrAuthPermit = [];
    foreach ($result as $value) {
        // d($result[$key]["username"]);
        // d($result[$key]["role"]);
        if (!($value["role"] === "")) {
            $arrAuthPermit[$value["username"]] = explode(",", $value["role"]);
        } else {
            $arrAuthPermit[$value["username"]] = [];
        }
    }
    echo json_encode([
        'page' => $page,
        'total_pages' => $total_pages,
        "total_record" => count($arrAuthPermit),
        "data" => $arrAuthPermit
    ]);
}
// dd($arrAuthPermit);
