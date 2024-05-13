<?php
class CarsManager
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function getCars()
    {
        $pathInfoArr1 = explode("/", $_SERVER["PATH_INFO"]);
        if ($pathInfoArr1[2] = 'shoes') {
            $module = $pathInfoArr1[3];
            // var_dump($pathInfoArr1[3]);
            // var_dump($module);
            $sqlId = "SELECT * FROM cars WHERE id = '$module'";
            $resultId = $this->pdo->query($sqlId);
            $searchIdd = $resultId->fetchAll(PDO::FETCH_ASSOC);
            if (is_null($searchIdd[0])) {
                echo json_encode(array("message" => "null"));
                exit;
            }
            echo json_encode($searchIdd[0]);
        }
    }
    public function postCar()
    {
        try {
            $pathInfoArr1 = explode("/", $_SERVER["PATH_INFO"]);

            $module = $pathInfoArr1[2];
            if ($module = "cars") {

                $data = json_decode(file_get_contents("php://input"), true);
                $name = $data['name'];
                $price = $data['price'];
              

                // Prepare the SQL statement
                $stmt = $this->pdo->prepare("INSERT INTO cars (name, price, categories) VALUES (:name, :price)");

                // Bind parameters
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':price', $price);
               

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
    public function delCar()
    {
        $pathInfoArr1 = explode("/", $_SERVER["PATH_INFO"]);
        if ($pathInfoArr1[2] = 'cars') {
            $module = $pathInfoArr1[3];
            // dd($module);
            $stmt = $this->pdo->prepare("DELETE FROM cars WHERE id = :id");

            // Bind parameter
            $stmt->bindParam(':id', $module);

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
    }
}
