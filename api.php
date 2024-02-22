<?php
header('Content-Type: application/json');
$host = '192.168.1.103:8306';
$dbname = 'tiendata';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// // Kiểm tra phương thức HTTP
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        //SEARCH name
        $searchField = isset($_GET['action']) && $_GET['action'] === 'search' ? 'name' : '';
        $searchTerm = isset($_GET[$searchField]) ? $_GET[$searchField] : '';

        $searchID = (isset($_GET['action']) && $_GET['action'] === 'search' ? 'id' : '');
        $searchDetail = isset($_GET[$searchID]) ? $_GET[$searchID] : '';

        // $filterField = isset($_GET['action']) && $_GET['action'] === 'filter' ? $_GET['field'] : '';
        // $filterValue = isset($_GET['value']) ? $_GET['value'] : '';
        // $comparison = isset($_GET['comparison']) ? $_GET['comparison'] : 'more';

        if (!empty($searchField) && !empty($searchTerm)) {
            $sqlName = "SELECT * FROM shoes WHERE name LIKE '%$searchTerm%'";
            $resultName = $pdo->query($sqlName);
            $searchResults = $resultName->fetchAll(PDO::FETCH_ASSOC);
            // Chuyển kết quả tìm kiếm thành mảng
            // $searchResults = array_values($searchResults);   
            // Trả về kết quả tìm kiếm
            echo json_encode($searchResults);
        }
        //SEARCH DETAIL
        else if (!empty($searchID) && !empty($searchDetail)) {
            $sqlId = "SELECT * FROM shoes WHERE id = '$searchDetail'";
            $resultId = $pdo->query($sqlId);
            $searchIdd = $resultId->fetchAll(PDO::FETCH_ASSOC);
            // Chuyển kết quả tìm kiếm thành mảng
            // $searchResults = array_values($searchResults);   
            // Trả về kết quả tìm kiếm
            echo json_encode($searchIdd);
        }
        //Filter
        else if (isset($_GET['min_number']) && isset($_GET['max_number'])) {
            // Get the min and max numbers from the parameters
            $minNumber = $_GET['min_number'];
            $maxNumber = $_GET['max_number'];

            // SQL query to filter data with less than and greater than conditions
            $sql = "SELECT * FROM shoes WHERE price < $maxNumber AND price> $minNumber";

            // Execute query
            $result = $pdo->query($sql);

            // Check if there are results
            if ($result) {
                $response = $result->fetchAll(PDO::FETCH_ASSOC);
                // Return data as JSON
                echo json_encode($response);
            }
        } else {
            $stmt = $pdo->query('SELECT * FROM shoes');
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $json = json_encode($data, JSON_PRETTY_PRINT);
            echo $json;
        }

        break;
}
            case 'POST':
            // // Xử lý yêu cầu POST, ví dụ: thêm mới dữ liệu
            // // Đọc dữ liệu từ yêu cầu
            // $postData = json_decode(file_get_contents('php://input'), true);
            // // Đọc giá trị id hiện tại từ tệp hoặc biến (id_counter.txt là một tệp lưu trữ giá trị id)
            // $idCounter = file_get_contents('id_counter.txt');
            // // Tăng giá trị id và lưu lại vào tệp hoặc biến
            // $newItemId = $idCounter + 1;
            // file_put_contents('id_counter.txt', $newItemId);
            // // Thêm dữ liệu mới
            // $newItem = array(
            // 'id' => $newItemId,
            // 'name' => $postData['name'],
            // 'price' => $postData['price']
            // );
            // $data[] = $newItem;
            // // Lưu lại dữ liệu mới vào tệp JSON
            // file_put_contents('shoes.json', json_encode($data));
            // // Trả về dữ liệu mới đã thêm
            // echo json_encode($newItem);
            break;

            // case 'DELETE':
            // // Xử lý yêu cầu DELETE, ví dụ: xóa dữ liệu
            // $deleteId = $_GET['id'];
            // // Kiểm tra xem id cần xóa có tồn tại trong dữ liệu không
            // $idExists = in_array($deleteId, array_column($data, 'id'));

            // if ($idExists) {
            // // Thực hiện xóa dữ liệu
            // foreach ($data as $key => $item) {
            // if ($item['id'] == $deleteId) {
            // unset($data[$key]);
            // break;
            // }
            // }
            // // Giảm giá trị id
            // $maxId = max(array_column($data, 'id'));
            // file_put_contents('id_counter.txt', $maxId);

            // // Lưu lại dữ liệu đã được cập nhật vào tệp JSON
            // file_put_contents('shoes.json', json_encode(array_values($data)));

            // echo json_encode(array('message' => 'Item deleted successfully'));
            // } else {
            // // Trường hợp id không tồn tại, trả về lỗi
            // http_response_code(404);
            // echo json_encode(array('message' => 'Not Found - ID does not exist'));
            // }
            // break;
            // case 'PUT':
            // // Xử lý yêu cầu PUT, ví dụ: cập nhật dữ liệu
            // // Đọc dữ liệu từ yêu cầu
            // $putData = json_decode(file_get_contents('php://input'), true);
            // $updateId = $putData['id'];

            // // Kiểm tra tính duy nhất của id
            // $idExists = in_array($updateId, array_column($data, 'id'));

            // if ($idExists) {
            // // Thực hiện cập nhật dữ liệu
            // foreach ($data as &$item) {
            // if ($item['id'] == $updateId) {
            // $item['name'] = $putData['name'];
            // $item['price'] = $putData['price'];
            // break;
            // }
            // }

            // // Lưu lại dữ liệu đã được cập nhật vào tệp JSON
            // file_put_contents('shoes.json', json_encode($data));

            // echo json_encode(array('message' => 'Item updated successfully'));
            // } else {
            // // Trường hợp id không tồn tại, trả về lỗi
            // http_response_code(404);
            // echo json_encode(array('message' => 'Not Found - ID does not exist'));
            // }
            // break;
            // case 'PATCH':
            // // Xử lý yêu cầu PATCH, ví dụ: cập nhật một số trường dữ liệu
            // // Đọc dữ liệu từ yêu cầu
            // $patchData = json_decode(file_get_contents('php://input'), true);
            // $patchId = $patchData['id'];

            // // Kiểm tra tính duy nhất của id
            // $idExists = in_array($patchId, array_column($data, 'id'));

            // if ($idExists) {
            // // Thực hiện cập nhật dữ liệu (ví dụ: cập nhật một số trường)
            // foreach ($data as &$item) {
            // if ($item['id'] == $patchId) {
            // // Cập nhật một số trường dữ liệu, ví dụ: 'name'
            // if (isset($patchData['name'])) {
            // $item['name'] = $patchData['name'];
            // }
            // if (isset($patchData['price'])) {
            // $item['price'] = $patchData['price'];
            // }
            // // Cập nhật một số trường dữ liệu khác nếu cần
            // // ...

            // break;
            // }
            // }

            // // Lưu lại dữ liệu đã được cập nhật vào tệp JSON
            // file_put_contents('shoes.json', json_encode($data));

            // echo json_encode(array('message' => 'Item patched successfully'));
            // } else {
            // // Trường hợp id không tồn tại, trả về lỗi
            // http_response_code(404);
            // echo json_encode(array('message' => 'Not Found - ID does not exist'));
            // }
            // break;