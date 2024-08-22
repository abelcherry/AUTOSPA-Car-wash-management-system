<?php
// Database credentials
$servername = "localhost"; // Change this to your database server name if it's different
$username = "abel96"; // Change this to your database username
$password = "123456789"; // Change this to your database password
$dbname = "user_info"; // Change this to your database name

try {
    // Create connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
