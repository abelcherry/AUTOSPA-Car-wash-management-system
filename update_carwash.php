<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the car_id and other fields are set in the POST request
    if (isset($_POST["car_id"]) && isset($_POST["name"]) && isset($_POST["address"]) && isset($_POST["f1"]) && isset($_POST["r1"]) && isset($_POST["f2"]) && isset($_POST["r2"]) && isset($_POST["f3"]) && isset($_POST["r3"]) && isset($_POST["f4"]) && isset($_POST["r4"]) && isset($_POST["service1"]) && isset($_POST["service2"]) && isset($_POST["service3"]) && isset($_POST["service4"]) && isset($_POST["district"]) && isset($_POST["map_location"])) {
        // Extract car_id and other fields from the POST request
        $car_id = $_POST["car_id"];
        $name = $_POST["name"];
        $address = $_POST["address"];
        $f1 = $_POST["f1"];
        $r1 = $_POST["r1"];
        $f2 = $_POST["f2"];
        $r2 = $_POST["r2"];
        $f3 = $_POST["f3"];
        $r3 = $_POST["r3"];
        $f4 = $_POST["f4"];
        $r4 = $_POST["r4"];
        $service1 = $_POST["service1"];
        $service2 = $_POST["service2"];
        $service3 = $_POST["service3"];
        $service4 = $_POST["service4"];
        $district = $_POST["district"];
        $map_location = $_POST["map_location"];
        // Connect to your database
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

        // Prepare and execute SQL statement to update car wash details
        $sql = "UPDATE carwash_owners SET 
                name = '$name', 
                address = '$address', 
                facility1 = '$f1', 
                rate1 = '$r1', 
                facility2 = '$f2', 
                rate2 = '$r2', 
                facility3 = '$f3', 
                rate3 = '$r3', 
                facility4 = '$f4', 
                rate4 = '$r4', 
                service1 = '$service1', 
                service2 = '$service2', 
                service3 = '$service3', 
                service4 = '$service4', 
                district = '$district', 
                map_location = '$map_location'  
                WHERE id = '$car_id'";

        if ($conn->query($sql) === TRUE) {
            // Close database connection
            $conn->close();

            // Display alert and redirect to profile.php
            echo "<script>alert('Car wash details updated successfully');</script>";
            echo "<script>window.location = 'profile.php';</script>";
            exit();
        } else {
            echo "Error updating car wash details: " . $conn->error;
        }

        // Close database connection
        $conn->close();
    } else {
        echo "All fields are required";
    }
} else {
    // Redirect to the edit car wash page if accessed directly without form submission
    header("Location: edit_car.php");
    exit();
}
?>
