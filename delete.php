<?php

/** FOR DEV_TIEN */
header('Content-Type: application/json');
$host = '192.168.1.103:8306';
$dbname = 'tiendata';
$username = 'root';
$password = 'root';

try {
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

    $id = 94;
 // Prepare the DELETE statement
 $stmt = $pdo->prepare("DELETE FROM shoes WHERE id = :id");

 // Bind parameter
 $stmt->bindParam(':id', $id);

 // Execute the statement
 try {
     $stmt->execute();
     http_response_code(200); // OK
     echo json_encode(array("message" => "Record deleted successfully."));
 } catch (PDOException $e) {
     http_response_code(500); // Internal Server Error
     echo json_encode(array("message" => "Failed to delete record: " . $e->getMessage()));
 }
 
?>
?>