<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect to login page if not logged in
    header("Location: admin_login.php");
    exit();
}

// Connect to the database
$servername = "localhost";
$username = "abel96";
$password = "123456789";
$database = "user_info";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Logic for approving turfs
if (isset($_POST['approve_car'])) {
    $car_id = $_POST['id'];

    // Retrieve turf details from the turfs table
    $sql_select = "SELECT * FROM carwash_owner WHERE id = $car_id";
    $result = $conn->query($sql_select);

    if ($result->num_rows > 0) {
        // Insert turf details into the approved_turfs table
        $row = $result->fetch_assoc();
        $sql = "INSERT INTO carwash_owners (name, address, facility1, rate1, facility2, rate2, facility3, rate3, facility4, rate4, service1, service2, service3, service4, district, map_location, contact, email, image1, image2, image3, image4)
            VALUES ('$name', '$address', '$facility1', '$rate1', '$facility2', '$rate2', '$facility3', '$rate3', '$facility4', '$rate4', '$service1', '$service2', '$service3', '$service4', '$district', '$map_location', '$contact', '$email', '$image1', '$image2', '$image3', '$image4')";

        $conn->query($sql);

        // Delete turf from the turfs table
        $sql_delete = "DELETE FROM turfs WHERE id = $car_id";
        $conn->query($sql_delete);
    }
}

// Logic for searching turfs
// Implement search functionality here

// Logic for editing turf details
// Implement editing functionality here

// Close the database connection
$conn->close();
?>

<!-- HTML for admin dashboard -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome, Admin</h1>
    <h2>Approve car wash centres</h2>
    <!-- Display list of turfs waiting for approval -->
    <form action="" method="POST">
        <!-- Loop through turfs waiting for approval -->
        <?php
        // Fetch turfs waiting for approval from the turfs table
        $sql_select_waiting = "SELECT * FROM carwash_owners";
        $result_waiting = $conn->query($sql_select_waiting);

        if ($result_waiting->num_rows > 0) {
            while ($row_waiting = $result_waiting->fetch_assoc()) {
                echo "<div>";
                echo "<p>Name: " . $row_waiting['name'] . "</p>";
                echo "<p>Address: " . $row_waiting['address'] . "</p>";
                // Add more details as needed
                echo "<input type='hidden' name='id' value='" . $row_waiting['id'] . "'>";
                echo "<button type='submit' name='approve_car'>Approve</button>";
                echo "</div>";
            }
        } else {
            echo "<p>No car wash centre waiting for approval</p>";
        }
        ?>
    </form>

    <!-- Other sections for searching turfs and editing turf details -->
</body>
</html>
