<?php
try {

    $data = json_decode(file_get_contents("php://input"), true);
    $username = $data['user'];
    $roles = $data['roles'];
    // Prepare the SQL statement
    //    dd($roles);
    $role = implode(",", $roles);
    // dd($role);
    $sql = "SELECT role FROM user_login  WHERE username = '$username' ";
    $result = $pdo->query($sql);
    $result = $result->fetchAll(PDO::FETCH_ASSOC);
    // dd($result);
    // foreach($result as $value) {
    //     // $newRole = implode(",", $value['role']);
    //     d($value['role']);
    // }
    $newRole = $result[0]['role'];
    // dd($newRole);
    if($newRole==="") {
        $stmt  = $pdo->prepare("UPDATE user_login SET role = :role WHERE username = :username");
    }
    else {
        $stmt  = $pdo->prepare("UPDATE user_login SET role = '$newRole' + ',' + :role WHERE username = :username");
    }
    // Bind parameters
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':role', $role);
    // Execute the statement
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        // Handle the case where 0 rows were affected
        $message = "No matching records found for role";
    } else {
        // Handle the successful delete operation
        $message = "add role successfully";
    }
    http_response_code(200); // OK
    echo json_encode(array("message" => $message));
} catch (PDOException $e) {
    echo "Error updating: " . $e->getMessage();
}
