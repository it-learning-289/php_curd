<?php

// Path to your CSV file
$csv_file = 'data.csv';
dd(fopen($csv_file, "r"));
// Read the CSV file
if (($handle = fopen($csv_file, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $name = $conn->real_escape_string($data[0]); // Escape any special characters
        $price = $conn->real_escape_string($data[1]); // Escape any special characters

        // SQL query to insert data into database
        $sql = "INSERT INTO cars (name, price ) VALUES ('$name', '$price')";

        if ($conn->query($sql) === TRUE) {
            echo "Record inserted successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    fclose($handle); // Close the CSV file
}

$conn->close(); // Close the database connection
?>
