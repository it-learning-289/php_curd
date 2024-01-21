//PHP
<?php

// API endpoint URL
$apiUrl = 'http://localhost:3000/adidas';

// Fetch data from the API
$response = file_get_contents($apiUrl);

// Check for errors
if ($response === FALSE) {
    echo 'Error fetching data from the API';
} else {
    // Process the API response (assuming it's in JSON format)
    $data = json_decode($response, true);

    // Check if the data is an array and not empty
    if (is_array($data) && !empty($data)) {
        // Create a table and display data
        echo '<table border="1">';
        echo '<thead><tr><th>ID</th><th>Name</th><th>Price</th></tr></thead>';
        echo '<tbody>';
        
        foreach ($data as $item) {
            echo '<tr>';
            echo '<td>' . $item['id'] . '</td>';
            echo '<td>' . $item['name'] . '</td>';
            echo '<td>' . $item['price'] . '</td>';

            echo '<td>';
            echo '<form method="post" action="index.php">';
            echo '<input type="hidden" name="id" value="' . $item['id'] . '">';
            echo '<button type="submit">Xóa</button>';
            echo '</form>';
            echo '</td>';

            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo 'No data available from the API';
    }
}
//get data from input form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Lấy dữ liệu từ ô input có tên là "username"
  $name = $_POST["name"];
  $price = $_POST["price"];
  // Hiển thị thông báo với dữ liệu đã lấy được
  //post request
  // API endpoint URL
$apiUrl = 'http://localhost:3000/adidas';

// Data to be sent in the POST request (in JSON format)
$data = array(
    'name' => $name,
    'price' => $price
);

// Convert the data to JSON
$jsonData = json_encode($data);

// Set stream context options for the POST request
$options = array(
    'http' => array(
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => $jsonData
    )
);

$context = stream_context_create($options);

// Send the POST request and get the response
$response = file_get_contents($apiUrl, false, $context);

}

//DELETE request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Get the ID from the form submission
  $id = $_POST["id"];
  // Perform the DELETE request to the API
  $apiUrl = 'http://localhost:3000/adidas' . $id;
  $options = [
      'http' => [
          'method' => 'DELETE',
      ],
  ];
  $context = stream_context_create($options);
  $result = file_get_contents($apiUrl, false, $context);

  if ($result === FALSE) {
      echo 'Error deleting the item';
  } else {
      echo 'Item deleted successfully';
  }
} else {
  echo 'Invalid request';
}
?>

//HTML 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="index.php" method="post">
    <!-- Ô input text -->
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    <label for="price">Price:</label>
    <input type="text" id="price" name="price" required>
    <!-- Nút submit để gửi dữ liệu -->
    <input type="submit" value="Submit">
</form>
</body>
</html>