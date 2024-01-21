<?php
header('Content-Type: application/json');

// Đọc dữ liệu từ tệp JSON
$data = json_decode(file_get_contents('shoes.json'), true);

// Kiểm tra phương thức HTTP
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Trả về toàn bộ dữ liệu
        echo json_encode($data);
        break;

    case 'POST':
        // Xử lý yêu cầu POST (ví dụ: thêm mới dữ liệu)
        $postData = json_decode(file_get_contents('php://input'), true);

        // Thêm dữ liệu mới
        $newItem = [
            'id' => count($data) + 1,
            'name' => $postData['name'],
            'price' => $postData['price']
        ];

        $data[] = $newItem;

        // Lưu lại dữ liệu mới vào tệp JSON
        file_put_contents('shoes.json', json_encode($data));

        // Trả về dữ liệu mới đã thêm
        echo json_encode($newItem);
        break;

    // Các trường hợp xử lý PUT, DELETE có thể được thêm vào tùy thuộc vào yêu cầu của bạn

    default:
        // Trường hợp mặc định, trả về lỗi không hỗ trợ phương thức
        http_response_code(405);
        echo json_encode(['message' => 'Method Not Allowed']);
        break;
}
?>
