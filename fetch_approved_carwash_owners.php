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

// Prepare and execute query to fetch approved car wash owners
$sql_carwash_approved = "SELECT * FROM carwash_owners WHERE approved = 1"; // Assuming there's a column named 'approved' indicating approval status
$result_carwash_approved = $conn->query($sql_carwash_approved);

// Check if the query executed successfully
if ($result_carwash_approved === false) {
    echo "Error executing query: " . $conn->error;
    // Handle the error as needed
} else {
    // Check if approved car wash owners exist
    if ($result_carwash_approved->num_rows > 0) {
        // Fetch and display approved car wash owners
        while ($row = $result_carwash_approved->fetch_assoc()) {
            // Display each approved car wash owner
            $id = $row["id"];
            $name = $row["name"];
            $address = $row["address"];
            ?>
            <div class="car-section">
                <h2>Car Wash Details</h2>
                <div class="car-details">
                    <label>ID:</label>
                    <span><?php echo $id; ?></span>
                </div>
                <div class="car-details">
                    <label>Name:</label>
                    <span><?php echo $name; ?></span>
                </div>
                <div class="car-details">
                    <label>Address:</label>
                    <span><?php echo $address; ?></span>
                </div>
                <!-- Add more details as needed -->
            </div>
            <br><br>
            <?php
        }
    } else {
        echo "No approved car wash owners.";
    }
}

// Close the database connection
$conn->close();
?>
