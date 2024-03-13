<?php
function shoeGet()
{
    global $pdo;
    // dd("anh chao em");
    //SEARCH name
    // $searchField = isset($_GET['action']) && $_GET['action'] === 'search' ? 'name' : '';
    // $searchTerm = isset($_GET[$searchField]) ? $_GET[$searchField] : '';

    // $searchID = (isset($_GET['action']) && $_GET['action'] === 'search' ? 'id' : '');
    // $searchDetail = isset($_GET[$searchID]) ? $_GET[$searchID] : '';

    // $filterField = isset($_GET['action']) && $_GET['action'] === 'filter' ? $_GET['field'] : '';
    // $filterValue = isset($_GET['value']) ? $_GET['value'] : '';
    // $comparison = isset($_GET['comparison']) ? $_GET['comparison'] : 'more';

    // if (!empty($searchField) && !empty($searchTerm)) {
    //     $sqlName = "SELECT * FROM shoes WHERE name LIKE '%$searchTerm%'";
    //     $resultName = $pdo->query($sqlName);
    //     $searchResults = $resultName->fetchAll(PDO::FETCH_ASSOC);
    //     // Chuyển kết quả tìm kiếm thành mảng
    //     // $searchResults = array_values($searchResults);   
    //     // Trả về kết quả tìm kiếm
    //     echo json_encode($searchResults);
    // }
    //SEARCH DETAIL
    $pathInfoArr1 = explode("/", $_SERVER["PATH_INFO"]);
    if ($pathInfoArr1[2] = 'shoes') {
        $module = $pathInfoArr1[3];
        // var_dump($pathInfoArr1[3]);
        // var_dump($module);
        $sqlId = "SELECT * FROM shoes WHERE id = '$module'";
        $resultId = $pdo->query($sqlId);
        $searchIdd = $resultId->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($searchIdd[0]);
    }
    // else if (!empty($searchID) && !empty($searchDetail)) {
    //     $sqlId = "SELECT * FROM shoes WHERE id = '$searchDetail'";
    //     $resultId = $pdo->query($sqlId);
    //     $searchIdd = $resultId->fetchAll(PDO::FETCH_ASSOC);
    //     // Chuyển kết quả tìm kiếm thành mảng
    //     // $searchResults = array_values($searchResults);   
    //     // Trả về kết quả tìm kiếm
    //     echo json_encode($searchIdd);
    // }

    //Filter
    // else if (isset($_GET['min_number']) && isset($_GET['max_number'])) {
    //     // Get the min and max numbers from the parameters
    //     $minNumber = $_GET['min_number'];
    //     $maxNumber = $_GET['max_number'];

    //     // SQL query to filter data with less than and greater than conditions
    //     $sql = "SELECT * FROM shoes WHERE price < $maxNumber AND price> $minNumber";

    //     // Execute query
    //     $result = $pdo->query($sql);

    //     // Check if there are results
    //     if ($result) {
    //         $response = $result->fetchAll(PDO::FETCH_ASSOC);
    //         // Return data as JSON
    //         echo json_encode($response);
    //     }
    // }
    // //PAGINATION
    // if ($_GET['page'] != "") {
    //     $limit = 10; // Number of records per page
    //     // Get page numfber from the request, default to page 1
    //     $page = isset($_GET['page']) ? $_GET['page'] : 1;
    //     $start = ($page - 1) * $limit;

    //     // Query to fetch records for the current page
    //     $stmt = $pdo->prepare("SELECT shoes.id, shoes.name ,shoes.price , category.name AS categories FROM shoes INNER JOIN category   ON shoes.categories=category.id LIMIT :start, :limit");
    //     $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    //     $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    //     $stmt->execute();
    //     $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     // var_dump($users);

    //     // Total number of records (for pagination)
    //     $total_stmt = $pdo->query("SELECT COUNT(*)  from (SELECT shoes.id, shoes.name ,shoes.price , category.name AS categories FROM shoes INNER JOIN category   ON shoes.categories=category.id) tmp");
    //     $total_rows = $total_stmt->fetchColumn();
    //     $total_pages = ceil($total_rows / $limit);

    //     // Construct the API response
    //     $response = [
    //         'page' => $page,
    //         'total_pages' => $total_pages,
    //         'total_records' => $total_rows,
    //         'users' => $users
    //     ];

    //     // Set headers to JSON

    //     // Output JSON response
    //     echo json_encode($response);
    // }
    //         // else {
    //         //     $stmt = $pdo->query('SELECT * FROM shoes');
    //         //     $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //         //     $json = json_encode($data, JSON_PRETTY_PRINT);
    //         //     echo $json;
    //         // }
}
shoeGet();