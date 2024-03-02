<?php
global $pdo;
if ($_GET['page'] != "") {
    $limit = 10; // Number of records per page
    // Get page numfber from the request, default to page 1
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1) * $limit;
    $stmt = $pdo->prepare("SELECT username, `role` FROM user_login LIMIT :start, :limit");
    $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $arrAuthPermit = [];
    foreach ($users as $value) {
     
        if (!($value["role"] === "")) {
            $arrAuthPermit[$value["username"]] = explode(",", $value["role"]);
        } else {
            $arrAuthPermit[$value["username"]] = [];
        }
    }
    $sql = "SELECT username, `role` FROM user_login";
    $result = $pdo->query($sql);
    $result = $result->fetchAll(PDO::FETCH_ASSOC);
    $total_rows = count($result);
    $total_pages = ceil($total_rows / $limit);
    if ($_GET['page'] > $total_pages) {
        echo json_encode(array("message" => "this page invalid"));
        exit;
    }
    echo json_encode([
        'page' => $page,
        'total_pages' => $total_pages,
        "total_record" => $total_rows,
        "data" => $arrAuthPermit
    ]);
}
// dd($arrAuthPermit);
