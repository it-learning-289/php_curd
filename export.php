<?php
function export($nameTable)
{
    global $pdo;
    // $nameTable = "shoes";
    // get data from mysql
    $stmt = $pdo->prepare("SELECT * FROM $nameTable");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Create file CSV
    $filename = 'export_data.csv';


    $fp = fopen('php://temp', 'w'); // open file temp
    if ($fp) {
        //put header of table : id, name,price,categories
        fputcsv($fp, array_keys($data[0]));
        // dd(($data[0]));

        // write data on file CSV 
        foreach ($data as $row) {
            fputcsv($fp, $row);
        }

        // Di chuyển về đầu file
        rewind($fp);
        // set up header to must download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        // // Output CSV ra trình duyệt
        fpassthru($fp);

        // close file temp
        fclose($fp);

        exit;
    } else {
        die('can not open file. ');
    }
}
