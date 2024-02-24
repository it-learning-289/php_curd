<?php
 $data = json_decode(file_get_contents("php://input"), true);
 if (empty($data['name']) ) {
     // If name or email is missing, return an error
     http_response_code(400); // Bad Request
     echo json_encode(array("message" => "Name   is required."));
     exit;
 }
 if ( empty($data['price'])) {
     // If name or email is missing, return an error
     http_response_code(400); // Bad Request
     echo json_encode(array("message" => "price  is required."));
     exit;
 }
 if (empty($data['categories'])) {
     // If name or email is missing, return an error
     http_response_code(400); // Bad Request
     echo json_encode(array("message" => "categories  is required."));
     exit;
 }

 $name = $data['name'];
 $price = $data['price'];
 $categories = $data['categories'];

 // Prepare the SQL statement
 $stmt = $pdo->prepare("INSERT INTO shoes (name, price, categories) VALUES (:name, :price, :categories)");

 // Bind parameters
 $stmt->bindParam(':name', $name);
 $stmt->bindParam(':price', $price);
 $stmt->bindParam(':categories', $categories);

 // Execute the statement
 try {
     $stmt->execute();
     http_response_code(201); // Created
     echo json_encode(array("message" => "created successfully."));
 } catch (PDOException $e) {
     http_response_code(500); // Internal Server Error
     echo json_encode(array("message" => "Database error: " . $e->getMessage()));
 }

// Lưu lại dữ liệu mới vào tệp JSON
// file_put_contents('shoes.json', json_encode($data));

// Trả về dữ liệu mới đã thêm
// echo json_encode($newItem);
