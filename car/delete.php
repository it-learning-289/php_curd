<?php
$pathInfoArr1 = explode("/", $_SERVER["PATH_INFO"]);
if ($pathInfoArr1[2] = 'cars') {
    $module = $pathInfoArr1[3];
    // var_dump($pathInfoArr1[3]);
    var_dump($module);


    $stmt = $pdo->prepare("DELETE FROM cars WHERE id = :id");

    // Bind parameter
    $stmt->bindParam(':id',  $module);

    // Execute the statement
    try {
        $stmt->execute();
        http_response_code(200); // OK
        echo json_encode(array("message" => "Record deleted successfully."));
    } catch (PDOException $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => "Failed to delete record: " . $e->getMessage()));
    }
}
