<?php
// Start the session
session_start();
$usernam = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Establish database connection
$servername = "localhost";
$username = "abel96";
$password = "123456789";
$database = "user_info";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['center_id'], $_POST['service'], $_POST['date'], $_POST['time'], $_POST['car-type'], $_POST['car-model'])) {
    // Retrieve form data and sanitize
    $selectedCenterId = mysqli_real_escape_string($conn, $_POST['center_id']);
    $selectedService = mysqli_real_escape_string($conn, $_POST['service']);
    $selectedDate = mysqli_real_escape_string($conn, $_POST['date']);
    $selectedTimeSlot = mysqli_real_escape_string($conn, $_POST['time']);
    $selectedCarType = mysqli_real_escape_string($conn, $_POST['car-type']);
    $selectedCarModel = mysqli_real_escape_string($conn, $_POST['car-model']);


    // Insert data into SQL table
    $insertQuery = "INSERT INTO slots (center_id, service, date, time, car_type, car_model, status, username) 
                    VALUES ('$selectedCenterId', '$selectedService', '$selectedDate', '$selectedTimeSlot', '$selectedCarType', '$selectedCarModel', 'booked', '$usernam')";
    if (mysqli_query($conn, $insertQuery)) {
        // Data inserted successfully
        // Redirect to the payment page
        header("Location: pay.html"); // Adjust the URL to match your payment page
        exit(); // Stop further execution
    } else {
        // Error inserting data
        echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting...</title>
</head>
<body>
    <script>
        // Redirecting to pay.html after 3 seconds (adjust the delay as needed)
        setTimeout(function() {
            window.location.href = "pay.html";
        }, 1); // 3000 milliseconds = 3 seconds
    </script>
    <p>Redirecting you to the payment page...</p>
</body>
</html>