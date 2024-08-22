<?php
// Establish database connection
$servername = "localhost";
$username = "abel96";
$password = "123456789";
$database = "user_info";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['center_id'], $_POST['date'])) {
    // Retrieve selected center_id and date from POST data
    $selectedCenterId = $_POST['center_id'];
    $selectedDate = $_POST['date'];

    // Query slots for selected center_id and date
    $slotsQuery = "SELECT * FROM slots WHERE center_id = '$selectedCenterId' AND date = '$selectedDate'";
    // Execute query and fetch results
    $slotsResult = mysqli_query($conn, $slotsQuery);
    $slots = mysqli_fetch_all($slotsResult, MYSQLI_ASSOC);

    // Retrieve booked slots for the selected center_id and date
    $bookedSlotsQuery = "SELECT time FROM slots WHERE center_id = '$selectedCenterId' AND date = '$selectedDate' AND status = 'booked'";
    $bookedSlotsResult = mysqli_query($conn, $bookedSlotsQuery);
    $bookedSlots = mysqli_fetch_all($bookedSlotsResult, MYSQLI_ASSOC);

    // Prepare response data
    $response = [
        'slots' => $slots,
        'bookedSlots' => $bookedSlots
    ];

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Handle the case when the required keys are not set
    echo "Required keys are not set in the POST array!";
}

mysqli_close($conn);
?>
