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
    $insertQuery = "INSERT INTO slots (center_id, service, date, time, car_type, car_model, status) 
                    VALUES ('$selectedCenterId', '$selectedService', '$selectedDate', '$selectedTimeSlot', '$selectedCarType', '$selectedCarModel', 'booked')";
    if (mysqli_query($conn, $insertQuery)) {
        // Data inserted successfully
        // Redirect to the payment page
        header("Location: pay.html"); // Adjust the URL to match your payment page
        exit();
    } else {
        // Error inserting data
        echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
    }
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
