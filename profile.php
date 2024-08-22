<?php
session_start();
$usernam = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

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

// Prepare and execute query to fetch user details
$username = $_SESSION["username"];
$sql_user = "SELECT * FROM users WHERE username = '$username'";
$result_user = $conn->query($sql_user);

// Check if user exists
if ($result_user->num_rows > 0) {
    // Fetch user data
    $userData = $result_user->fetch_assoc();

    // Check if the logged-in user is an admin
    $is_admin = ($_SESSION["username"] === 'admin');

    // Display slot booking details only if the user is not an admin
   
} else {
    // Handle case where user does not exist
    $errorMsg = "User not found.";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - car wash</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your custom CSS file -->
    <style>
        /* CSS for profile section */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden; /* Prevent scrolling */
        }

        .background-container {
            position: fixed;
            bottom:0;
            left: 0;
            width: 100%;
            height: 73%;
            background-image: url('loginbg.png');
            background-size: cover;
            filter: blur(2px); /* Apply blur effect */
            z-index: -1; /* Move behind content */
        }

        header {
            position: relative; /* Ensure header stays at the top */
            z-index: 1; /* Keep header above blurred background */
            background-color: black; /* Set background color */
            padding: 10px 0; /* Adjust padding as needed */
        }

        .logo {
            float: left;
            margin-left: 20px; /* Adjust margin as needed */
        }

        .logo img {
            height: 35px;
            width: auto;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        nav ul li {
            display: inline;
            margin-right: 20px; /* Adjust margin as needed */
        }

        .profile-section {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.7); /* Semi-transparent background */
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .profile-details {
            margin-bottom: 20px;
            background-color: #fff; /* White background */
            padding: 20px; /* Add padding */
            border-radius: 10px; /* Add border radius */
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1); /* Add shadow */
        }

        .profile-details label {
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        .profile-details span {
            color: #333;
        }

        .logout-link {
            text-align: center;
            margin-top: 30px;
        }

        .logout-link a {
            text-decoration: none;
            color: black;
            font-weight: bold;
            border: 2px solid black;
            padding: 10px 20px;
            border-radius: 30px;
            transition: background-color 0.3s, color 0.3s;
        }

        .logout-link a:hover {
            background-color: grey;
            color: #fff;
        }
        .section-container {
    margin: 20px auto;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.car-section {
    margin-bottom: 20px;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.car-details {
    margin-bottom: 10px;
}

.approve-button {
    background-color: black;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
}

.approve-button:hover {
    background-color: grey;
}
        
        body {
            overflow-y: auto; /* Enable vertical scrolling */
            background-image: url('search1.jpg'); 
        }
        /* CSS for the container holding both waiting and approved car wash centers */
.approved-and-waiting-container {
    display: flex;
    justify-content: space-between;
    margin: 0 auto;
    padding: 20px;
}

/* CSS for the waiting approval section */
.waiting-approval {
    flex: 1;
    margin-right: 20px;
}

/* CSS for the approved section */
.approved {
    flex: 1;
    margin-left: 20px;
}

/* CSS for the section container */
.section-container {
    margin-bottom: 20px;
}

/* CSS for the car section */
.car-section {
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

    </style>
</head>
<body>
    <div class="background-container"></div> <!-- Background container -->
    <header style="background-color:black; color:white;">
        <div class="logo">
            <img src="logo1.png" alt="Logo">
        </div>
        <nav>
            <ul style=" color:white;">
                <li><a href="car2.html">Home</a></li>
                
                <li><a href="about.html">About Us</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>
    </header> 
    <!-- Profile Section -->
    <div class="profile-section">
        <center><h1 style="color:black">User Profile</h1></center>
        

        <div class="profile-details">
            <label>Full Name:</label>
            <span><?php echo isset($userData['full_name']) ? $userData['full_name'] : ''; ?></span>
        </div>
        <div class="profile-details">
            <label>Username:</label>
            <span><?php echo isset($userData['username']) ? $userData['username'] : ''; ?></span>
        </div>
        <div class="profile-details">
            <label>Email:</label>
            <span><?php echo isset($userData['email']) ? $userData['email'] : ''; ?></span>
        </div>
        <div class="profile-details">
            <label>Phone Number:</label>
            <span><?php echo isset($userData['phone_number']) ? $userData['phone_number'] : ''; ?></span>
        </div>
        <!-- Logout option -->
        <div class="logout-link">
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <?php
    if (!$is_admin) {
        $servername = "localhost";
$username = "abel96";
$password = "123456789";
$database = "user_info";
    // Reconnect to the database
    $conn = new mysqli($servername, $username, $password, $database);

    // Prepare and execute query to fetch slot booking details for the user
    $sql_slots = "SELECT * FROM slots WHERE username = '$usernam'";
    $result_slots = $conn->query($sql_slots);

    // Check if slots exist for the user
    if ($result_slots->num_rows > 0) {
        // Display slot booking details for the user
        echo "<div class='section-container'>";
        echo "<h2>Slot Booking Details:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Center ID</th><th>Service</th><th>Date</th><th>Time</th><th>Status</th><th>Car Type</th><th>Car Model</th></tr>";
        while ($row = $result_slots->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["center_id"] . "</td>";
            echo "<td>" . $row["service"] . "</td>";
            echo "<td>" . $row["date"] . "</td>";
            echo "<td>" . $row["time"] . "</td>";
            echo "<td>" . $row["status"] . "</td>";
            echo "<td>" . $row["car_type"] . "</td>";
            echo "<td>" . $row["car_model"] . "</td>";
            echo "<td><button class='cancel-button' data-id='" . $row["id"] . "'>Cancel</button></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "<div class='section-container'>";
        echo "No slot booking details found for the user.";
        echo "</div>";
    }

    // Close the database connection
    $conn->close();
}
?>
    <?php if($is_admin): ?>
        <script>
        // Reload the page every 5 seconds
        setInterval(function(){
            location.reload();
        }, 10000);
    </script>
       <div class="approved-and-waiting-container">
    <!-- Car wash centers waiting for approval -->
    <div class="waiting-approval">
        
            <center><h2 style="position: relative; top: 50px;"><mark style="background-color: black; color:white;">car wash centeres Waiting for Approval</mark></h2></center>
            <!-- Add code to display carwash waiting for approval -->
            <div class="car-section-container">
            <?php
            $servername = "localhost";
            $username = "abel96";
            $password = "123456789";
            $database = "user_info";
            // Create connection
            $conn = new mysqli($servername, $username, $password, $database);
            // Prepare and execute query to fetch carwash waiting for approval
            $sql_car_waiting = "SELECT * FROM carwash_owners WHERE approved = 0"; // Assuming there's a column named 'approved' indicating approval status
            $result_car = $conn->query($sql_car_waiting);
            // Check if the query executed successfully
            if ($result_car === false) {
                echo "Error executing query: " . $conn->error;
                // Handle the error as needed
            } else {
                // Check if carwash are waiting for approval
                if ($result_car->num_rows > 0) {
                    // Display carwash waiting for approval
                    while ($row = $result_car->fetch_assoc()) {
                        // Display each carwash waiting for approval
                        $id = $row["id"];
                        $name = $row["name"];
                        $address = $row["address"];
                       
            ?>
                        <br><br>
                        <section>
                        <div class="section-container">
                        <div class="car-section">
                            <h2>car wash Details</h2>
                            <div class="car-details">
                                <label>car wash ID:</label>
                                <span><?php echo $id; ?></span>
                            </div>
                            <div class="car-details">
                                <label>centre Name:</label>
                                <span><?php echo $name; ?></span>
                            </div>
                            <div class="car-details">
                                <label>Address:</label>
                                <span><?php echo $address; ?></span>
                            </div>
                          
                            <button class="approve-button" onclick="approvecar(<?php echo $id; ?>, this)">Approve</button>
                        </div></div></section>
                    
            <?php
                    }
                } else {
                    echo "No car wash centres waiting for approval.";
                }
            }
            // Close the database connection
            $conn->close();
            ?>
        </div>  </div>
    
     <!-- Display approved -->
     <div class="approved">
     <center><h2 style="position: relative; top: 50px;"><mark style="background-color: black; color:white;">Approved car wash owners</mark></h2></center>
     <div class="approvedCarWashesContainer">
            <?php
            $servername = "localhost";
            $username = "abel96";
            $password = "123456789";
            $database = "user_info";
            // Create connection
            $conn = new mysqli($servername, $username, $password, $database);
            // Prepare and execute query to fetch carwash waiting for approval
            $sql_carwash_waiting = "SELECT * FROM carwash_owners WHERE approved = 1"; // Assuming there's a column named 'approved' indicating approval status
            $result_car = $conn->query($sql_carwash_waiting);
            // Check if the query executed successfully
            if ($result_car === false) {
                echo "Error executing query: " . $conn->error;
                // Handle the error as needed
            } else {
                // Check if carwash are waiting for approval
                if ($result_car->num_rows > 0) {
                    // Display carwash waiting for approval
                    while ($row = $result_car->fetch_assoc()) {
                        // Display each carwash waiting for approval
                        $id = $row["id"];
                        $name = $row["name"];
                        $address = $row["address"];
                        
            ?>
            <section>
                        <div class="section-container"> 
                        <div class="car-section">
                            <h2>car wash details</h2>
                            <div class="car-details">
                                <label> ID:</label>
                                <span><?php echo $id; ?></span>
                            </div>
                            <div class="car-details">
                                <label>Name:</label>
                                <span><?php echo $name; ?></span>
                            </div>
                            <div class="tcar-details">
                                <label>Address:</label>
                                <span><?php echo $address; ?></span>
                            </div>
                            
                            <button class="approve-button" onclick="disapprovecar(<?php echo $id; ?>, this)">Disapprove</button>
                        </div></div>
                    <br><br></section>
            <?php
                    }
                } else {
                    echo "No carwash owner waiting for approval.";
                }
            }
            // Close the database connection
            $conn->close();
            ?>
        </div><br><br>     </div>
</div>
    <!-- car Search Section -->
    <div class="section-container">
    <div>
    <center><h2 style="position: relative; bottom: 20px;">Search for carwash </h2> </center>
        <div class="search-bar" style="position: relative; left:450px;">               
                <form action="search-results.php" method="get" >
                    
                    <input type="text" id="searchInput"class="search-form" name="search" placeholder="Search by carwash name or District" style="width: 500px;">
                    <button type="submit">Search</button>
                </form>
            
            </div></div>
    </div><br><br><br>
    
    <div class="section-container">
    <div>
        <h2>Edit car wash Details</h2><br><br>
        <form id="editcarForm" action="edit_car.php" method="post">
    
    <!-- Other input fields for carwash details -->
    <button type="submit" style=" padding: 18px 36px; 
    border: none;
    background-color: black;
    color: #fff;
    border-radius: 50px;
    cursor: pointer;
    font-size: 18px; 
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">Edit carwash page</button>
</form>
        </div></div>
    <?php endif; ?>
    <br><br><br><br><br>
</body>
<script>
       

        // Call the function to load approvedcar when the page loads
        

        // Function to approve  dynamically
        function approvecar(id, button) {
        // Send an AJAX request to update the 'approved' column in the  table
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Handle the response
                console.log(this.responseText);
                // Remove the car section from the DOM
                var carSection = button.closest(".car-section");
                carSection.parentNode.removeChild(carSection);
            }loadApprovedcar();
        };
        xhttp.open("POST", "update_approval.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("carid=" + id);
        
    }
    function disapprovecar(id, button) {
        // Send an AJAX request to update the 'approved' column in thecar wash table
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Handle the response
                console.log(this.responseText);
                // Remove the car section from the DOM
                var carSection = button.closest(".car-section");
                carSection.parentNode.removeChild(carSection);
            }loadApprovedcar();
        };
        xhttp.open("POST", "update_disapproval.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("carid=" + id);
        
    }
    <!-- Add this line to loadApprovedcar() function -->
function loadApprovedcar() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("approvedCarWashesContainer").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "fetch_approved_carwash_owners.php", true);
    xhttp.send();
}


    </script>
    <script>
    // Add event listener to cancel buttons
    var cancelButtons = document.querySelectorAll('.cancel-button');
    cancelButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var confirmation = confirm("Are you sure you want to cancel this booking?");
            if (confirmation) {
                // Send AJAX request to delete the row
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Reload the page to reflect the changes
                        location.reload();
                    }
                };
                xhttp.open("POST", "cancel_booking.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("id=" + id);
            }
        });
    });
</script>

</html>
