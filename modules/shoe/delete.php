<?php
$pathInfoArr1 = explode("/", $_SERVER["PATH_INFO"]);
// var_dump(1);
// die();

if ($pathInfoArr1[2] = 'shoes') {
    $module = $pathInfoArr1[3];
    // var_dump($pathInfoArr1[3]);
    // var_dump($module);
    // die();

    $stmt = $pdo->prepare("DELETE FROM shoes WHERE id = :id");

    // Bind parameter
    $stmt->bindParam(':id',  $module);

    // Execute the statement
    try {
        $stmt->execute();
        // Check if the delete operation affected any rows
        if ($stmt->rowCount() == 0) {
            // Handle the case where 0 rows were affected
            $message = "No matching records found for deletion";
        } else {
            // Handle the successful delete operation
            $message = "Records deleted successfully";
        }
        http_response_code(200); // OK
        echo json_encode(array("message" => $message));
    } catch (PDOException $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => "Failed to delete record: " . $e->getMessage()));
    }
}
