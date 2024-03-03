<?php
    try {
    //    dd("Patch cars");
        $pathInfoArr1 = explode("/", $_SERVER["PATH_INFO"]);
    
        $module = $pathInfoArr1[2];
        if ($module = "cars") {
    
            $data = json_decode(file_get_contents("php://input"), true);
            $name = $data['name'];
            $price = $data['price'];
            // $categories = $data['category'];
    
            // Prepare the SQL statement
            $stmt = $pdo->prepare("INSERT INTO cars (name, price) VALUES (:name, :price)");
    
            // Bind parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            // $stmt->bindParam(':category', $categories);
    
            // Execute the statement
            $stmt->execute();
            http_response_code(201); // Created
            echo json_encode(array("message" => "created successfully."));
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => "Database error: " . $e->getMessage()));
    }

?>