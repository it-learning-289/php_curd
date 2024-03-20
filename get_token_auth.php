<?php

use Monolog\Logger;

class AuthTokenGenerator
{
    public static function generateAuthToken()
    {
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (isset($data['username']) && !empty($data['username']) && isset($data['password']) && !empty($data['password'])) {
                // Both username and password are provided and not empty
                $username = $data['username'];
                $password = $data['password'];

                $token = base64_encode($username . ":" . $password);
                http_response_code(200); // OK
                echo json_encode(array("tungtv_authen_token" => $token));
            } else {
                // Either username or password is missing or empty            
                throw new ErrorException("Username and password are required.");
            }
        } catch (Exception $e) {
            http_response_code(500); // Internal Server Error
            $log = new CustomLogger('get_Authen_token', './logs/AuthToken.log', Logger::INFO);
            $log->logError($e->getMessage());
            echo json_encode(array("message" => "Error: " . $e->getMessage()));
        }
    }
}

AuthTokenGenerator::generateAuthToken();
