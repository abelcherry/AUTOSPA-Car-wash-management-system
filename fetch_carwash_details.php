<?php
// Include database connection file
include 'db_connection.php';

// Check if car wash ID is provided in the request
if(isset($_GET['car_id'])) {
    try {
        // Get the car wash ID
        $carId = $_GET['car_id'];

        // Prepare SQL statement to fetch car wash details
        $sql = "SELECT * FROM carwash_owners WHERE id = ?";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind parameter
            $stmt->bindValue(1, $carId, PDO::PARAM_INT);

            // Execute the SQL query
            $stmt->execute();

            // Fetch the result set as an associative array
            $carwashDetails = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($carwashDetails) {
                // Return car wash details as JSON response
                header('Content-Type: application/json');
                echo json_encode($carwashDetails);
            } else {
                // Car wash details not found
                http_response_code(404);
                echo json_encode(array("message" => "Car wash details not found."));
            }
        } else {
            // Error preparing SQL statement
            throw new Exception("Error preparing SQL statement.");
        }
    } catch (Exception $e) {
        // Error occurred
        http_response_code(500);
        echo json_encode(array("message" => $e->getMessage()));
    }
} else {
    // Car wash ID not provided
    http_response_code(400);
    echo json_encode(array("message" => "Car wash ID not provided."));
}

// Close database connection
$conn = null;
?>
