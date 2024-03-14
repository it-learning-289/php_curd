<?php
class ShoesManager
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function handleGet()
    {
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
    }
}
