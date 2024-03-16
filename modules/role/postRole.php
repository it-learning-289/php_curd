<?php

class RoleUpdater {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function updateRole() {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $username = $data['user'];
            $roles = $data['roles'];

            $role = implode(",", $roles);

            $sql = "SELECT role FROM user_login  WHERE username = '$username' ";
            $result = $this->pdo->query($sql);
            $result = $result->fetchAll(PDO::FETCH_ASSOC);

            $newRole = $result[0]['role'];

            if ($newRole === "") {
                $stmt = $this->pdo->prepare("UPDATE user_login SET role = :role WHERE username = :username");
            } else {
                $stmt = $this->pdo->prepare("UPDATE user_login SET role = CONCAT(role, ',', :role) WHERE username = :username");
            }

            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':role', $role);

            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                $message = "No matching records found for role";
            } else {
                $message = "add role successfully";
            }

            http_response_code(200); // OK
            echo json_encode(array("message" => $message));
        } catch (PDOException $e) {
            echo "Error updating: " . $e->getMessage();
        }
    }
}

// Usage:
// $pdo = new PDO("mysql:host=localhost;dbname=mydatabase", "username", "password");
// $roleUpdater = new RoleUpdater($pdo);
// $roleUpdater->updateRole();

?>
