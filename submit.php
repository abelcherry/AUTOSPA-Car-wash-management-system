<?php
// Database configuration
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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $address = $_POST['address'];
    $facility1 = $_POST['f1'];
    $rate1 = $_POST['r1'];
    $facility2 = $_POST['f2'];
    $rate2 = $_POST['r2'];
    $facility3 = $_POST['f3'];
    $rate3 = $_POST['r3'];
    $facility4 = $_POST['f4'];
    $rate4 = $_POST['r4'];
    $service1 = $_POST['service1'];
    $service2 = $_POST['service2'];
    $service3 = $_POST['service3'];
    $service4 = $_POST['service4'];
    $district = $_POST['district'];
    $map_location = $_POST['map_location'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $image1 = $_FILES['image1']['name'];
    $image2 = $_FILES['image2']['name'];
    $image3 = $_FILES['image3']['name'];
    $image4 = $_FILES['image4']['name'];

    // Upload image files
    $targetDir = "uploads/";
    move_uploaded_file($_FILES['image1']['tmp_name'], __DIR__ . DIRECTORY_SEPARATOR . $targetDir . $image1);
    move_uploaded_file($_FILES['image2']['tmp_name'], __DIR__ . DIRECTORY_SEPARATOR . $targetDir . $image2);
    move_uploaded_file($_FILES['image3']['tmp_name'], __DIR__ . DIRECTORY_SEPARATOR . $targetDir . $image3);
    move_uploaded_file($_FILES['image4']['tmp_name'], __DIR__ . DIRECTORY_SEPARATOR . $targetDir . $image4);


    // Insert data into database
    $sql = "INSERT INTO carwash_owners (name, address, facility1, rate1, facility2, rate2, facility3, rate3, facility4, rate4, service1, service2, service3, service4, district, map_location, contact, email, image1, image2, image3, image4)
            VALUES ('$name', '$address', '$facility1', '$rate1', '$facility2', '$rate2', '$facility3', '$rate3', '$facility4', '$rate4', '$service1', '$service2', '$service3', '$service4', '$district', '$map_location', '$contact', '$email', '$image1', '$image2', '$image3', '$image4')";

    if ($conn->query($sql) === TRUE) {
        // Close connection
        $conn->close();

        // Redirect to car2.html after 1 millisecond
        echo "<script>setTimeout(function() { window.location.href = 'car2.html'; }, 1);</script>";
        exit; // Stop further execution
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
