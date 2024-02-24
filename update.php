<?php
header('Content-Type: application/json');
$host = '10.110.69.10';
$port = 8806;
$dbname = 'tiendata';
$username = 'root';
$password = 'root';

// PDO connection string
$dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';port=' . $port;

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $username, $password);
    // Now you can use $pdo for your database operations
    // echo "Connection ok";
} catch (PDOException $e) {
    // Handle connection errors
    echo "Connection failed: " . $e->getMessage();
}

// $brands = ["NikeierbfikasbnfkjasnejfnaNikeierbNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswfikasbnfkjasnejfnaswswefNikeierbfikasbnfkjasnejfnaNikeierbNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswfikasbnfkjasnejfnaswswefNikeierbfikasbnfkjasnejfnaNikeierbNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswfikasbnfkjasnejfnaswswef",
//  "AdidasaawseNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswfawsfswfawefNikeierbfikasbnfkjasnejfnaNikeierbNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswfikasbnfkjasnejfnaswswefNikeierbfikasbnfkjasnejfnaNikeierbNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswfikasbnfkjasnejfnaswswefNikeierbfikasbnfkjasnejfnaNikeierbNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswfikasbnfkjasnejfnaswswef",
//   "DiorawsfbawsieasrfewarfejhfbaNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswfnaswskhjbfaweuaywegfvjhvcjhasgfiyawbevNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswfkjhwbsevfGuccifDiorawsfbawsieasrfewarfejhfbaNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswfnaswskhjbfaweuaywegfvjhvcjhasgfiyawbevNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswfkjhwbsevfGuccif", 
//  "uaywegfvjhvcjhasgfiyawbevNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswfkjhwbsevfGucciuaywegfvjhvcjhasgfiyawbevNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswNikeierbfikasbnfkjasnejfnaswfkjhwbsevfGucci"
// ];

$brands = [1,2,3,4];
// echo "Random Brand: " . $random_brand;
// $random_key = array_rand($brands);
// echo $brands[$random_key];

for ($x = 1; $x <= 10200; $x++) {
    $random_key = array_rand($brands);
    $random_brand = $brands[$random_key];
    // echo $random_brand;
    $stmt = $pdo->query("UPDATE shoes SET categories =  '$random_brand' WHERE id= '$x' ");
    // $stmt = $pdo->query("UPDATE shoes SET categories = '$random_brand' WHERE id= 334");
    echo $x, PHP_EOL;
}

// $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
// $stmt1 = $pdo->query('SELECT * FROM shoes');
// $data = $stmt1->fetchAll(PDO::FETCH_ASSOC);
// $json = json_encode($data, JSON_PRETTY_PRINT);
// echo $json;
// $json = json_encode($data, JSON_PRETTY_PRINT);
// echo $json;
