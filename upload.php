<?php
// require_once "./Dev_Tien.php";

$target_dir = "uploads/";
// Xóa tất cả các file trong thư mục uploads trước khi upload
$files = glob($target_dir . '*'); // Lấy danh sách tất cả các file trong thư mục
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file); // Xóa file
    }
}
// Kiểm tra xem request có phải là POST không
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Đường dẫn lưu trữ file (trong ví dụ này là thư mục uploads/)

    // Tạo thư mục nếu không tồn tại
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Đường dẫn tới file upload
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    // Kiểm tra nếu file đã tồn tại
    if (file_exists($target_file)) {
        echo "File đã tồn tại.";
    } else {
        // Di chuyển file từ thư mục tạm sang thư mục lưu trữ
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

            require_once "./import.php";
            die();
            echo "File " . basename($_FILES["file"]["name"]) . " đã được upload thành công.";
        } else {
            echo "Đã xảy ra lỗi khi upload file.";
        }
    }
} else {
    // Nếu không phải là phương thức POST, trả về lỗi
    http_response_code(405);
    echo "Phương thức không được hỗ trợ.";
}
