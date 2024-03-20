<?php

use Monolog\Logger;

class UserRegistration
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function registerUser()
    {
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (isset($data['username']) && !empty($data['username']) && isset($data['password']) && !empty($data['password'])) {
                // Both username and password are provided and not empty
                $username = $data['username'];
                $password = $data['password'];
                $stmt = $this->pdo->prepare("INSERT INTO user_login (username, password) VALUES (:name, :password)");
                // Bind parameters
                $stmt->bindParam(':name', $username);
                $stmt->bindParam(':password', $password);
                // Execute the statement
                $stmt->execute();
                if ($stmt->rowCount() == 0) {
                    // Handle the case where 0 rows were affected
                    throw new Exception("Records created Error");
                } else {
                    // Handle the successful insert operation
                    $message = "Records created successfully";
                }
                http_response_code(201); // Created
                echo json_encode(array("message" => $message));
            } else {
                // Either username or password is missing or empty
                throw new ErrorException("Username and password are required.");
            }
        } catch (Exception $e) {
            http_response_code(500); // Internal Server Error
            $log = new CustomLogger('register', './logs/register.log', Logger::INFO);
            $log->logError($e->getMessage());
            echo json_encode(array("message" => "Error: " . $e->getMessage()));
        }
    }
}

global $pdo;
// dd($pdo);
$userRegistration = new UserRegistration($pdo);
$userRegistration->registerUser();
