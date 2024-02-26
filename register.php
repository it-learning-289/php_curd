<?php
try {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['username']) && !empty($data['username']) && isset($data['password']) && !empty($data['password'])) {
        // Both username and password are provided and not empty
        $username = $data['username'];
        $password = $data['password'];
        $stmt = $pdo->prepare("INSERT INTO user_login (username, password) VALUES (:name, :password)");
        // Bind parameters
        $stmt->bindParam(':name', $username);
        $stmt->bindParam(':password', $password);
        // Execute the statement
        $stmt->execute();
        http_response_code(201); // Created
        echo json_encode(array("message" => "created successfully."));
    } else {
        // Either username or password is missing or empty
        throw new ErrorException("Username and password are required.");
    }
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Error: " . $e->getMessage()));
}
