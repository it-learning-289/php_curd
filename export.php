<?php
class CsvExporter {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function export($nameTable) {
        // get data from MySQL
        $stmt = $this->pdo->prepare("SELECT * FROM $nameTable");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Create CSV file
        $filename = 'export_data.csv';
        $fp = fopen('php://temp', 'w'); // open temp file

        if ($fp) {
            // Put the header of the table: id, name, price, categories
            fputcsv($fp, array_keys($data[0]));

            // Write data to CSV file
            foreach ($data as $row) {
                fputcsv($fp, $row);
            }

            // Move back to the beginning of the file
            rewind($fp);

            // Set up headers to force download
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            // Output CSV to browser
            fpassthru($fp);

            // Close temp file
            fclose($fp);

            exit;
        } else {
            die('Cannot open file.');
        }
    }
}

// Sử dụng class CsvExporter
// require_once "./connectMysql/Dev_Tien.php"; // Include file chứa kết nối PDO

$csvExporter = new CsvExporter($pdo);
$csvExporter->export("cars");
?>
