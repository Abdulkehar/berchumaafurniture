<?php
$servername = "localhost";
$username = "root";
$password = ""; // Use your actual database password
$dbname = "furniture_sales";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the JSON input from the POST request
$data = json_decode(file_get_contents("php://input"), true);

// Verify if the data is valid
if (is_array($data) && !empty($data)) {
    // Loop through each row of data and insert it into the database
    foreach ($data as $entry) {
        $name = $entry['name'];
        $phone = $entry['phone'];
        $prepaid = $entry['prepaid'];
        $value = $entry['value'];
        $date = $entry['date'];
        $furniture = $entry['furniture'];
        $days = $entry['days'];
        $confirmed = $entry['confirmed'] ? 1 : 0;

        // Prepare the SQL query
        $sql = "INSERT INTO sales_tracking (name, phone, prepaid, value, payment_date, furniture, days, confirmed)
                VALUES ('$name', '$phone', '$prepaid', '$value', '$date', '$furniture', '$days', '$confirmed')";

        // Execute the query
        if (!$conn->query($sql)) {
            echo "Error: " . $conn->error;
            exit;
        }
    }
    echo "Data saved successfully!";
} else {
    echo "Invalid input data.";
}

// Close the database connection
$conn->close();
?>
