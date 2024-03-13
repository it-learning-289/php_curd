<?php
class UploadAndImport {
    private $targetDir;

    public function __construct($targetDir) {
        $this->targetDir = $targetDir;
    }

    public function handleUploadAndImport() {
        // Xóa tất cả các file trong thư mục uploads trước khi upload
        $this->clearUploadsDirectory();

        // Kiểm tra xem request có phải là POST không
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Tạo thư mục nếu không tồn tại
            if (!file_exists($this->targetDir)) {
                mkdir($this->targetDir, 0777, true);
            }

            // Đường dẫn tới file upload
            $target_file = $this->targetDir . basename($_FILES["file"]["name"]);

            // Kiểm tra nếu file đã tồn tại
            if (file_exists($target_file)) {
                echo "File đã tồn tại.";
            } else {
                // Di chuyển file từ thư mục tạm sang thư mục lưu trữ
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    require_once "./import.php";
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
    }

    private function clearUploadsDirectory() {
        $files = glob($this->targetDir . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}

// Sử dụng class UploadAndImport
$uploader = new UploadAndImport("uploads/");
$uploader->handleUploadAndImport();
?>
