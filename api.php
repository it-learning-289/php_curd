<?php

header('Content-Type: application/json');

// Đọc dữ liệu từ tệp JSON
$jsonData = file_get_contents('shoes.json');
$data = json_decode($jsonData, true);

// Kiểm tra phương thức HTTP
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Trả về toàn bộ dữ liệu
        echo json_encode($data);
        break;

    case 'POST':
        // Xử lý yêu cầu POST, ví dụ: thêm mới dữ liệu
        // Đọc dữ liệu từ yêu cầu
        $postData = json_decode(file_get_contents('php://input'), true);

        // Đọc giá trị id hiện tại từ tệp hoặc biến (id_counter.txt là một tệp lưu trữ giá trị id)
        $idCounter = file_get_contents('id_counter.txt');

        // Tăng giá trị id và lưu lại vào tệp hoặc biến
        $newItemId = $idCounter + 1;
        file_put_contents('id_counter.txt', $newItemId);

        // Thêm dữ liệu mới
        $newItem = array(
            'id' => $newItemId,
            'name' => $postData['name'],
            'price' => $postData['price']
        );

        $data[] = $newItem;

        // Lưu lại dữ liệu mới vào tệp JSON
        file_put_contents('shoes.json', json_encode($data));

        // Trả về dữ liệu mới đã thêm
        echo json_encode($newItem);
        break;
        case 'DELETE':
            // Xử lý yêu cầu DELETE, ví dụ: xóa dữ liệu
            $deleteId = $_GET['id'];
        
            // Kiểm tra xem id cần xóa có tồn tại trong dữ liệu không
            $idExists = in_array($deleteId, array_column($data, 'id'));
        
            if ($idExists) {
                // Thực hiện xóa dữ liệu
                foreach ($data as $key => $item) {
                    if ($item['id'] == $deleteId) {
                        unset($data[$key]);
                        break;
                    }
                }
        
                // Giảm giá trị id
                $maxId = max(array_column($data, 'id'));
                file_put_contents('id_counter.txt', $maxId);
        
                // Lưu lại dữ liệu đã được cập nhật vào tệp JSON
                file_put_contents('shoes.json', json_encode(array_values($data)));
        
                echo json_encode(array('message' => 'Item deleted successfully'));
            } else {
                // Trường hợp id không tồn tại, trả về lỗi
                http_response_code(404);
                echo json_encode(array('message' => 'Not Found - ID does not exist'));
            }
            break;
        
}
