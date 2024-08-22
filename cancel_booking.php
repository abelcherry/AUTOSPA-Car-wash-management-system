<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

// Check if the ID is provided
if (isset($_POST['id'])) {
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

    // Prepare and execute query to delete the row
    $id = $_POST['id'];
    $sql_delete = "DELETE FROM slots WHERE id = '$id'";
    if ($conn->query($sql_delete) === TRUE) {
        echo "Booking cancelled successfully";
    } else {
        echo "Error: " . $sql_delete . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
