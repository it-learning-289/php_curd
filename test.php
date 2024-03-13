// Xác thực người dùng từ API
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$data = json_decode(file_get_contents("php://input"));

// Lấy thông tin từ client
$username = $data->username;
$password = $data->password;

// Query kiểm tra trong MySQL
$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
// Người dùng hợp lệ
$response = array("status" => "success", "message" => "Authentication successful");
} else {
// Người dùng không hợp lệ
$response = array("status" => "error", "message" => "Authentication failed");
}

// Trả kết quả về cho client
header('Content-Type: application/json');
echo json_encode($response);
}