<?php

class RoleManager {
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
    public function getRoles() {
        if ($_GET['page'] != "") {
            $limit = 5; // Number of records per page
            // Get page number from the request, default to page 1
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $start = ($page - 1) * $limit;

            // Prepare the SQL statement
            $stmt = $this->pdo->prepare("SELECT role FROM roles LIMIT :start, :limit");
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Get total rows
            $totalStmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM roles");
            $totalStmt->execute();
            $totalResult = $totalStmt->fetch(PDO::FETCH_ASSOC);
            $total_rows = $totalResult['total'];
            
            $total_pages = ceil($total_rows / $limit);
            if ($_GET['page'] > $total_pages) {
                echo json_encode(array("message" => "this page invalid"));
                exit;
            }

            echo json_encode([
                'page' => $page,
                'total_pages' => $total_pages,
                "total_record" => $total_rows,
                "data" => $users
            ]);
        }
    }
    public function getUserRolesByPage() {
        // Check if page and limit parameters are provided
        if (isset($_GET['page']) && isset($_GET['limit'])) {
            $limit = $_GET['limit']; // Number of records per page
            if ($limit > 100) {
                echo json_encode(array("message" => "Exceed the allowed limit (<=100)"));
                exit;
            }

            // Prepare the main SQL query to fetch user roles
            $sql = "SELECT user_login.id as user_id, user_login.username, roles.role, roles.name_role 
                    FROM user_login 
                    LEFT JOIN user_role ON user_login.id = user_role.user_id 
                    LEFT JOIN roles ON roles.id = user_role.role_id";

            // Execute the query to get total rows
            $totalStmt = $this->pdo->query($sql);
            $totalResult = $totalStmt->fetchAll(PDO::FETCH_ASSOC);
            $total_rows = count($totalResult);

            // Calculate total pages
            $total_pages = ceil($total_rows / $limit);

            // Check for valid page
            if (isset($_GET['page']) && $_GET['page'] > $total_pages) {
                echo json_encode(array("message" => "Invalid page number"));
                exit;
            }

            // Get start index for pagination
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $start = ($page - 1) * $limit;

            // Prepare the SQL query with LIMIT for pagination
            $stmt = $this->pdo->prepare("SELECT user_login.id as user_id, user_login.username, roles.role, roles.name_role 
                                         FROM user_login 
                                         LEFT JOIN user_role ON user_login.id = user_role.user_id 
                                         LEFT JOIN roles ON roles.id = user_role.role_id 
                                         LIMIT :start, :limit");
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $userRoles = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Organize the data into desired format
            $arrAuthPermit = [];
            foreach ($userRoles as $index => $value) {
                if (!is_null($value["role"])) {
                    $arrAuthPermit[$value["username"]][] = implode("", explode(",", $value["role"]));
                } else {
                    $arrAuthPermit[$value["username"]] = [];
                }
            }

            // Return the result as JSON
            echo json_encode([
                'page' => $page,
                'total_pages' => $total_pages,
                "total_record" => $total_rows,
                "data" => $arrAuthPermit
            ]);
        } else {
            echo json_encode(array("message" => "Please provide both page and limit"));
        }
    }
    public function getRoleUsersByPage() {
   
        // Check if page and limit parameters are provided
        if (isset($_GET['page']) && isset($_GET['limit'])) {
            $limit = $_GET['limit']; // Number of records per page
            if ($limit > 100) {
                echo json_encode(array("message" => "Exceed the allowed limit (<=100)"));
                exit;
            }

            // Prepare the main SQL query to fetch user roles
            $sql = "SELECT roles.id as role_id, roles.role, user_login.username, roles.name_role 
                    FROM roles 
                    LEFT JOIN user_role ON roles.id = user_role.role_id 
                    LEFT JOIN user_login ON user_login.id = user_role.user_id";

            // Execute the query to get total rows
            $totalStmt = $this->pdo->query($sql);
            $totalResult = $totalStmt->fetchAll(PDO::FETCH_ASSOC);
            $total_rows = count($totalResult);

            // Calculate total pages
            $total_pages = ceil($total_rows / $limit);

            // Check for valid page
            if (isset($_GET['page']) && $_GET['page'] > $total_pages) {
                echo json_encode(array("message" => "Invalid page number"));
                exit;
            }

            // Get start index for pagination
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $start = ($page - 1) * $limit;

            // Prepare the SQL query with LIMIT for pagination
            $stmt = $this->pdo->prepare("SELECT roles.id as role_id, roles.role, user_login.username, roles.name_role 
                                         FROM roles 
                                         LEFT JOIN user_role ON roles.id = user_role.role_id 
                                         LEFT JOIN user_login ON user_login.id = user_role.user_id 
                                         LIMIT :start, :limit");
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $userRoles = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Organize the data into desired format
            $arrAuthPermit = [];
            foreach ($userRoles as $index => $value) {
                if (!is_null($value["username"])) {
                    $arrAuthPermit[$value["role"]][] = implode("", explode(",", $value["username"]));
                } else {
                    $arrAuthPermit[$value["role"]] = [];
                }
            }
            
            // Return the result as JSON
            echo json_encode([
                'page' => $page,
                'total_pages' => $total_pages,
                "total_record" => $total_rows,
                "data" => $arrAuthPermit
            ]);
        } else {
            echo json_encode(array("message" => "Please provide both page and limit"));
        }
    }
   
}