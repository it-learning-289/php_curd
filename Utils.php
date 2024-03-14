<?php


class ApiHandler
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getUsernamePassFromToken()
    {
        $tungtvAuthTokenDecode = base64_decode($_SERVER["HTTP_TUNGTV_AUTHEN_TOKEN"]);
        return explode(':', $tungtvAuthTokenDecode);
    }

    public function checkAuthForApi()
    {
        if (array_key_exists("HTTP_TUNGTV_AUTHEN_TOKEN", $_SERVER)) {
            list($decoded_username, $decoded_password) = $this->getUsernamePassFromToken();
            $authen = new Authen($decoded_username, $decoded_password);
            // Authenticate the user
            if (!$authen->authenticate()) {
                header("HTTP/1.1 401 Unauthen");
                echo json_encode(array("message" => "Authen Failed"));
                exit;
            }
        } else {
            header("HTTP/1.1 401 Unauthen");
            echo json_encode(array("message" => "Unauthen"));
            exit;
        }
    }
}
