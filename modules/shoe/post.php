<?php
function shoePost()
{
    global $pdo;
    try {
        $pathInfoArr1 = explode("/", $_SERVER["PATH_INFO"]);

        $module = $pathInfoArr1[2];
        if ($module = "shoes") {

            $data = json_decode(file_get_contents("php://input"), true);
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
            // http_response_code(201); // Created
            // echo json_encode(array("message" => "created successfully."));
            if ($stmt->rowCount() == 0) {
                // Handle the case where 0 rows were affected
                $message = "No matching records found for creation";
            } else {
                // Handle the successful delete operation
                $message = "created successfully";
            }
            http_response_code(200); // OK
            echo json_encode(array("message" => $message));
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => "Database error: " . $e->getMessage()));
    }
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

    // Lưu lại dữ liệu mới vào tệp JSON
    // file_put_contents('shoes.json', json_encode($data));

    // Trả về dữ liệu mới đã thêm
    // echo json_encode($newItem);
}
shoePost();
