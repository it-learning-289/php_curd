<?php
try {
    $data = json_decode(file_get_contents("php://input"), true);
    // if (empty($data['name'])) {
    //     // If name or email is missing, return an error
    //     http_response_code(400); // Bad Request
    //     echo json_encode(array("message" => "Name   is required."));
    //     exit;
    // }
    // if (empty($data['price'])) {
    //     // If name or email is missing, return an error
    //     http_response_code(400); // Bad Request
    //     echo json_encode(array("message" => "price  is required."));
    //     exit;
    // }
    // if (is_null($data['category'])) {
    //     // If name or email is missing, return an error
    //     http_response_code(400); // Bad Request
    //     echo json_encode(array("message" => "category  is required."));
    //     exit;
    // }
    // $sql = "SELECT id FROM category ";

    // // Execute query
    // $result1 = $pdo->query($sql);

    // // Check if there are results
    // if ($result1) {
    //     $response1 = $result1->fetchAll(PDO::FETCH_ASSOC);
    //     // Return data as JSON
    //     // echo $response1;

    //     $array = array();
    //     foreach ($response1 as $row) {
    //         // echo ($row['id']);
    //         $array[] = $row['id'];
    //     }


    //     if (!in_array($data['category'], $array)) {
    //         echo json_encode(array("message" => "category is invalid"));
    //         exit;
    //     }



    // echo json_encode($response1);

    // if (is_null($data['category'])) {
    //     echo json_encode(array("message" => "category is null"));
    //     exit;
    // }
    $name = $data['name'];
    $price = $data['price'];
    $categories = $data['category'];

    // Prepare the SQL statement
    $stmt = $pdo->prepare("INSERT INTO shoes (name, price, categories) VALUES (:name, :price, :category)");

    // Bind parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':category', $categories);

    // Execute the statement
    $stmt->execute();
    http_response_code(201); // Created
    echo json_encode(array("message" => "created successfully."));
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Database error: " . $e->getMessage()));
}

// Lưu lại dữ liệu mới vào tệp JSON
// file_put_contents('shoes.json', json_encode($data));

// Trả về dữ liệu mới đã thêm
// echo json_encode($newItem);
