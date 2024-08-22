<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit car wash centre Details</title>
    <style>
        /* Your CSS styles */
    </style>
</head>
<body>
<div class="container">
    <h1>Edit car wash Details</h1>
    <form id="editcarForm" action="update_carwash.php" method="post">
        <label for="car_id">Enter Car Wash ID:</label><br>
        <input type="text" id="car_id" name="car_id"><br>
        <input type="button" id="fetchcarDetails" value="Fetch Car Wash Details"><br><br>

        <!-- Input fields for car wash details -->
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="address">Address:</label>
        <textarea id="address" name="address" rows="3" required></textarea><br><br>
        
        <!-- Add input fields for other car wash details -->
        <label for="f1">Facility 1:</label>
                <textarea id="f1" name="f1" rows="3" required></textarea>
            
                <label for="r1">rate of Facility1:</label>
                <textarea id="r1" name="r1" rows="1"></textarea>
            
                <label for="f2">Facility2:</label>
                <textarea id="f2" name="f2" rows="3" required></textarea>
            
                <label for="r2">rate of Facility2:</label>
                <textarea id="r2" name="r2" rows="1"></textarea>
           
                <label for="f3">Facility3:</label>
                <textarea id="f3" name="f3" rows="3" required></textarea>
          
                <label for="r3">rate of Facility3:</label>
                <textarea id="r3" name="r3" rows="1"></textarea>
            
                <label for="f4">Facility4:</label>
                <textarea id="f4" name="f4" rows="3" required></textarea>
           
                <label for="r4">rate of Facility4:</label>
                <textarea id="r4" name="r4" rows="1"></textarea>
            
        <!-- Add similar fields for facility1, rate_facility1, facility2, rate_facility2, and so on -->

        <label for="service1">Service Detail 1:</label>
        <textarea id="service1" name="service1" rows="3" required></textarea>
        
        <label for="service2">Service Detail 2:</label>
        <textarea id="service2" name="service2" rows="3" required></textarea>
        
        <label for="service3">Service Detail 3:</label>
        <textarea id="service3" name="service3" rows="3" required></textarea>
        
        <label for="service4">Service Detail 4:</label>
        <textarea id="service4" name="service4" rows="3" required></textarea>
        <label for="district">District:</label>
        <input type="text" id="district" name="district" required><br><br>

        <label for="district">District:</label>
        <input type="text" id="district" name="district" required><br><br>

        <label for="map_location">Map Location:</label>
        <input type="text" id="map_location" name="map_location" required><br><br>

        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact"><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br><br>
    
        <input type="submit" value="Save Changes">
    </form>
</div>
<script>
document.getElementById("fetchcarDetails").addEventListener("click", function() {
    // Get the car wash ID entered by the user
    var carId = document.getElementById("car_id").value;

    // Fetch car wash details using AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log("Response:", xhr.responseText); // Log the response
                if (xhr.responseText.startsWith('{')) {
                    try {
                        var carDetails = JSON.parse(xhr.responseText);
                        console.log("Parsed JSON:", carDetails); // Log the parsed JSON
                        // Fill input fields with car wash details
                        document.getElementById("name").value = carDetails.name;
                        document.getElementById("address").value = carDetails.address;
                        document.getElementById("f1").value = carDetails.facility1;
                        document.getElementById("f2").value = carDetails.facility2;
                        document.getElementById("f3").value = carDetails.facility3;
                        document.getElementById("f4").value = carDetails.facility4;
                        document.getElementById("service1").value = carDetails.service1;
                        document.getElementById("service2").value = carDetails.service2;
                        document.getElementById("service3").value = carDetails.service3;
                        document.getElementById("service4").value = carDetails.service4;
                        document.getElementById("r1").value = carDetails.rate1;
                        document.getElementById("r2").value = carDetails.rate2;
                        document.getElementById("r3").value = carDetails.rate3;
                        document.getElementById("r4").value = carDetails.rate4;
                        document.getElementById("district").value = carDetails.district;
                        document.getElementById("map_location").value = carDetails.map_location;
                        document.getElementById("contact").value = carDetails.contact;
                        document.getElementById("email").value = carDetails.email;
                    } catch (error) {
                        console.error("Error parsing JSON:", error);
                    }
                } else {
                    console.error("Unexpected response format: " + xhr.responseText);
                }
            } else {
                // Handle error
                console.error("Error fetching car wash details: " + xhr.status);
            }
        }
    };

    // Open and send AJAX request
    xhr.open("GET", "fetch_carwash_details.php?car_id=" + carId, true);
    xhr.send();
});
</script>

</body>
</html>
