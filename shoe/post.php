<?php

// Xử lý yêu cầu POST, ví dụ: thêm mới dữ liệu
// Đọc dữ liệu từ yêu cầu
$postData = json_decode(file_get_contents('php://input'), true);

// // Đọc giá trị id hiện tại từ tệp hoặc biến (id_counter.txt là một tệp lưu trữ giá trị id)
// $idCounter = file_get_contents('id_counter.txt');

// // Tăng giá trị id và lưu lại vào tệp hoặc biến
// $newItemId = $idCounter + 1;
// file_put_contents('id_counter.txt', $newItemId);
$stmt = $pdo->prepare("SELECT * FROM shoes LIMIT :start, :limit");
// Thêm dữ liệu mới
$newItem = array(
    'name' => $postData['name'],
    'price' => $postData['price']
);

$data[] = $newItem;

// Lưu lại dữ liệu mới vào tệp JSON
file_put_contents('shoes.json', json_encode($data));

// Trả về dữ liệu mới đã thêm
echo json_encode($newItem);
