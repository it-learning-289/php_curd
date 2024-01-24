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

        //SEARCH ....action=search&&name=""
        // Xử lý yêu cầu GET, ví dụ: lấy dữ liệu và tìm kiếm theo trường cụ thể
        $searchField = isset($_GET['action']) && $_GET['action'] === 'search' ? 'name' : '';
        $searchTerm = isset($_GET[$searchField]) ? $_GET[$searchField] : '';

        if (!empty($searchField) && !empty($searchTerm)) {
            // Nếu có trường tìm kiếm và giá trị tìm kiếm, thực hiện tìm kiếm
            $searchResults = array_filter($data, function ($item) use ($searchField, $searchTerm) {
                return strpos($item[$searchField], $searchTerm) !== false;
            });

            // Chuyển kết quả tìm kiếm thành mảng
            $searchResults = array_values($searchResults);

            // Trả về kết quả tìm kiếm
            echo json_encode($searchResults);
        } else {
            // Nếu không có trường tìm kiếm hoặc giá trị tìm kiếm, trả về toàn bộ dữ liệu
            echo json_encode($data);
        }
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
    case 'PUT':
        // Xử lý yêu cầu PUT, ví dụ: cập nhật dữ liệu
        // Đọc dữ liệu từ yêu cầu
        $putData = json_decode(file_get_contents('php://input'), true);
        $updateId = $putData['id'];

        // Kiểm tra tính duy nhất của id
        $idExists = in_array($updateId, array_column($data, 'id'));

        if ($idExists) {
            // Thực hiện cập nhật dữ liệu
            foreach ($data as &$item) {
                if ($item['id'] == $updateId) {
                    $item['name'] = $putData['name'];
                    $item['price'] = $putData['price'];
                    break;
                }
            }

            // Lưu lại dữ liệu đã được cập nhật vào tệp JSON
            file_put_contents('shoes.json', json_encode($data));

            echo json_encode(array('message' => 'Item updated successfully'));
        } else {
            // Trường hợp id không tồn tại, trả về lỗi
            http_response_code(404);
            echo json_encode(array('message' => 'Not Found - ID does not exist'));
        }
        break;
    case 'PATCH':
        // Xử lý yêu cầu PATCH, ví dụ: cập nhật một số trường dữ liệu
        // Đọc dữ liệu từ yêu cầu
        $patchData = json_decode(file_get_contents('php://input'), true);
        $patchId = $patchData['id'];

        // Kiểm tra tính duy nhất của id
        $idExists = in_array($patchId, array_column($data, 'id'));

        if ($idExists) {
            // Thực hiện cập nhật dữ liệu (ví dụ: cập nhật một số trường)
            foreach ($data as &$item) {
                if ($item['id'] == $patchId) {
                    // Cập nhật một số trường dữ liệu, ví dụ: 'name'
                    if (isset($patchData['name'])) {
                        $item['name'] = $patchData['name'];
                    }
                    if (isset($patchData['price'])) {
                        $item['price'] = $patchData['price'];
                    }
                    // Cập nhật một số trường dữ liệu khác nếu cần
                    // ...

                    break;
                }
            }

            // Lưu lại dữ liệu đã được cập nhật vào tệp JSON
            file_put_contents('shoes.json', json_encode($data));

            echo json_encode(array('message' => 'Item patched successfully'));
        } else {
            // Trường hợp id không tồn tại, trả về lỗi
            http_response_code(404);
            echo json_encode(array('message' => 'Not Found - ID does not exist'));
        }
        break;
}
