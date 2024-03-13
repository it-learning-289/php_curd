<?php
class CsvImporter
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function importCsv($csvFile, $tableName, $columns)
    {
        // Mở file CSV
        $file = fopen($csvFile, "r");

        // Đọc từng dòng trong file CSV và insert vào database
        if ($file !== FALSE) {
            // Bỏ qua dòng đầu tiên trong file CSV (nếu chứa tiêu đề)
            fgets($file);

            // Bắt đầu transaction để thêm dữ liệu vào bảng
            $this->pdo->beginTransaction();

            // Đọc từng dòng trong file CSV và thêm vào database
            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                $stmt = $this->pdo->prepare($this->buildInsertQuery($tableName, $columns));
                foreach ($columns as $index => $column) {
                    $stmt->bindParam(":$column", $data[$index]);
                }
                $stmt->execute();
            }

            // Commit transaction
            $this->pdo->commit();

            // Đóng file CSV
            fclose($file);

            echo "Import dữ liệu từ file CSV thành công.";
        } else {
            echo "Không thể mở file CSV.";
        }
    }

    private function buildInsertQuery($tableName, $columns)
    {
        $columnNames = implode(", ", $columns);
        $columnPlaceholders = implode(", ", array_map(function ($col) {
            return ":$col";
        }, $columns));

        return "INSERT INTO $tableName ($columnNames) VALUES ($columnPlaceholders)";
    }
}

// Sử dụng class CsvImporter
require_once "./Dev_Tien.php"; // Include file chứa kết nối PDO

$csvImporter = new CsvImporter($pdo);
$csvFile = "D:/My workspace/myProject/php_curd_API/uploads/" . basename($_FILES["file"]["name"]);
$tableName = "cars";
$columns = ["name", "price"];
$csvImporter->importCsv($csvFile, $tableName, $columns);
