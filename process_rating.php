<?php
// Retrieve rating and car wash ID from POST request
$rating = $_POST['rating'];
$carwash_id = $_POST['carwash_id'];
$username = $_POST['username'];

// Validate the data
if (!isset($rating) || !isset($carwash_id) || !isset($username)) {
    die("Error: Incomplete data received");
}

// Sanitize the input data to prevent SQL injection
$rating = floatval($rating);
$carwash_id = intval($carwash_id);
$username = htmlspecialchars($username);

// Connect to the database (replace 'your_database_credentials' with actual database credentials)
$mysqli = new mysqli("localhost", "abel96", "123456789", "user_info");

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Prepare and execute a query to insert the new rating into the ratings table
$stmt = $mysqli->prepare("INSERT INTO ratings (carwash_id, rating, username) VALUES (?, ?, ?)");
$stmt->bind_param("ids", $carwash_id, $rating, $username);

// Check for errors in preparing the query
if (!$stmt) {
    die("Error in preparing statement: " . $mysqli->error);
}

// Execute the prepared statement
if (!$stmt->execute()) {
    die("Error in executing statement: " . $stmt->error);
}

$stmt->close();

// Calculate the new average rating for the car wash center
$result = $mysqli->query("SELECT AVG(rating) AS average_rating FROM ratings WHERE carwash_id = $carwash_id");

// Check for errors in the query
if (!$result) {
    die("Error in query: " . $mysqli->error);
}

$row = $result->fetch_assoc();
$new_average_rating = $row['average_rating'];

// Update the average_rating column in the carwash_owners table
if (!$mysqli->query("UPDATE carwash_owners SET average_rating = $new_average_rating WHERE id = $carwash_id")) {
    die("Error in updating average rating: " . $mysqli->error);
}

// Close the database connection
$mysqli->close();

// Send a response back to the client
echo "Rating received and average rating updated successfully";
?>
