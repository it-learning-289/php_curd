<?php

require_once "./Dev_Tien.php";
// Đường dẫn đến file CSV cần import


$csvFile = "D:\My workspace\php_curd\uploads\\"  . basename($_FILES["file"]["name"]);
// $csvFile = "hello";
// var_dump($csvFile);
// die();
// Mở file CSV
// Đọc từng dòng trong file CSV và insert vào database
$file = fopen($csvFile, "r");
if ($file !== FALSE) {
    // Bỏ qua dòng đầu tiên trong file CSV (nếu chứa tiêu đề)
    fgets($file);
    
    // Bắt đầu transaction để thêm dữ liệu vào bảng
    $pdo->beginTransaction();

    // Đọc từng dòng trong file CSV và thêm vào database
    while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
        $stmt = $pdo->prepare("INSERT INTO cars (name, price) VALUES (:name, :price)");
        $stmt->bindParam(':name', $data[0]);
        $stmt->bindParam(':price', $data[1]);
        $stmt->execute();
    }

    // Commit transaction
    $pdo->commit();

    // Đóng file CSV
    fclose($file);

    echo "Import dữ liệu từ file CSV thành công.";
} else {
    echo "Không thể mở file CSV.";
}
