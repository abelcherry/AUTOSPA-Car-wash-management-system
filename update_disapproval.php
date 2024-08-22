<?php
// Connect to the database
$servername = "localhost";
$username = "abel96";
$password = "123456789";
$database = "user_info";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if carId is set in the POST request
if (isset($_POST["carid"])) {
    // Sanitize input to prevent SQL injection
    $carId = $conn->real_escape_string($_POST["carid"]);

    // Update the 'approved' column in the carwash_owners table
    $sql = "UPDATE carwash_owners SET approved = 0 WHERE id = '$carId'";
    if ($conn->query($sql) === TRUE) {
        echo "car wash approval status updated successfully";
    } else {
        echo "Error updating car wash owners approval status: " . $conn->error;
    }
} else {
    echo "car wash ID not provided";
}

// Close the database connection
$conn->close();
?>
