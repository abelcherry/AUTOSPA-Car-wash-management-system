<?php
session_start(); // Move session_start() to the beginning

// Include database connection file
include 'db_connection.php';

// Check if car wash center ID is set in URL parameters
if(isset($_GET['id'])) {
    // Get the car wash center ID
    $carwashId = $_GET['id'];

    // Prepare SQL statement to retrieve car wash center details by ID
    $sql = "SELECT carwash_owners.*, AVG(ratings.rating) AS average_rating 
            FROM carwash_owners 
            LEFT JOIN ratings ON carwash_owners.id = ratings.carwash_id 
            WHERE carwash_owners.id = :carwashId 
            GROUP BY carwash_owners.id";

    // Prepare the SQL statement with a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind the car wash center ID parameter
    $stmt->bindValue(':carwashId', $carwashId, PDO::PARAM_INT);

    // Execute the prepared statement
    $stmt->execute();

    // Fetch the result as an associative array
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Close the prepared statement
    $stmt = null;
} else {
    // If car wash center ID is not set, display a message
    echo "<p>No car wash center ID specified</p>";
    exit; // Exit script if car wash ID is not provided
}

// Close database connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Wash Details</title>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f3f3;
            color: #333;
            min-height: 100vh;
            position: relative;
        }

        header {
            /* Add banner image */
            background-size: cover;
            color: #fff;
            padding: 50px 20px;
            text-align: center;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            padding-bottom: 50px; /* Adjust for footer height */
        }
        .container {
    display: flex;
    flex-wrap: wrap;
}

        h1, h2, h3 {
            color: #fff;
        }

        h2 {
            margin-top: 20px;
        }

        .facility-container,
        
.map-container {
    background-color: #000;
    color: #fff;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    flex: 1 1 calc(50% - 20px); /* Adjust width as needed, considering margin */
    margin-right: 20px;
}

.facility-container {
    background-color: #000;
    color: #fff;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    flex: 1 1 calc(50% - 20px); /* Adjust width as needed, considering margin */
    margin-right: 20px;
}
        
        #mapid {
            height: 300px;
            width: 100%;
        }
        header {
    background-color: #333;
    color: #fff;
    padding: 20px 0;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

        .reviews-container {
            background-color: #000;
            color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            flex: 1 1 100%;
        }
        .review {
            margin-bottom: 20px;
            background-color:grey;
        }

        .review h3 {
            margin-bottom: 5px;
        }

        .rating {
            color: #ffc107;
        }
        #hi{
            background-image: url('banner2.jpg');
        }

        .footer {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .logo {
    float: left;
    margin-right: 100px; /* Adjusted margin for closer positioning to the top left corner */
    margin-top: -50px; /* Adjusted margin for closer positioning to the top left corner */
}

nav {
    text-align: center;
}

nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

nav ul {
    display: inline-block;
    margin-top: 10px;
}

nav ul li {
    display: inline;
    margin-right: 20px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
    transition: color 0.3s ease;
    font-size: 18px;
    font-weight: bold;
    text-transform: uppercase;
}

nav ul li a:hover {
    color: #ffc107;
}

.user-menu {
    position: absolute;
    top: 10px;
    right: 20px;
}

.user-icon {
    width: 30px;
    height: auto;
    cursor: pointer;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #333;
    min-width: 120px;
    z-index: 1;
    border-radius: 5px;
    top: 40px;
    right: 0;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
}

.dropdown-content a {
    color: #fff;
    padding: 10px;
    text-decoration: none;
    display: block;
    transition: background-color 0.3s ease;
}

.dropdown-content a:hover {
    background-color: #555;
}

.user-menu:hover .dropdown-content {
    display: block;
}
.center-heading {
            text-align: center;
            margin: 0 auto;
            background-color: #000;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2)}
            * {box-sizing:border-box}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Hide the images by default */
.mySlides {
  display: none;
  max-width: 500px; /* Adjust the maximum width as needed */
  margin: auto;
}


/* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  margin-top: -22px;
  padding: 16px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
}
.selected {
    background-color:green;
    color: #fff;
}


/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.8);
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active, .dot:hover {
  background-color: #717171;
}

/* Fading animation */
.fade {
  animation-name: fade;
  animation-duration: 1.5s;
}

@keyframes fade {
  from {opacity: .4}
  to {opacity: 1}
}
.btn {
    display: inline-block;
    background-color: #ff6600;
    color: #fff;
    text-decoration: none;
    padding: 12px 24px;
    border-radius: 25px;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #e65c00;
}
.facility {
    display: flex;
    justify-content: space-between;
}

.facility-box {
    flex: 1;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    text-align: center;
    margin-right: 10px;
}

.facility-box img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 50%;
    margin-bottom: 10px;
}
.button {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 60px;
  height: 60px;
  border-radius: 100%;
  border: none;
  background-color:black;
}

.button:hover {
  background-color: black;
}.instagram:hover {
        background: #f09433;
        background: -moz-linear-gradient(
          45deg,
          #f09433 0%,
          #e6683c 25%,
          #dc2743 50%,
          #cc2366 75%,
          #bc1888 100%
        );
        background: -webkit-linear-gradient(
          45deg,
          #f09433 0%,
          #e6683c 25%,
          #dc2743 50%,
          #cc2366 75%,
          #bc1888 100%
        );
        background: linear-gradient(
          45deg,
          #f09433 0%,
          #e6683c 25%,
          #dc2743 50%,
          #cc2366 75%,
          #bc1888 100%
        );
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f09433', endColorstr='#bc1888',GradientType=1 );}
        .social {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: 1px solid rgb(194, 194, 194);
      }
      .service-details {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.service {
    flex: 1 1 calc(45% - 20px); /* Adjust width of individual service blocks */
    margin-bottom: 20px;
}

.service-container {
    background-color: #fff;
    color: #333;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}
.service-container h3 {
    color: #000; /* Black color for the h3 tag */
}
/* Rating section */
#rating-section {
    margin-top: 20px;
    border-top: 1px solid #ccc;
    padding-top: 20px;
}

#rating-section h3 {
    margin-bottom: 10px;
    font-size: 18px;
    color: white;
}

.rating-stars {
    display: flex;
    align-items: center;
}

.star {
    font-size: 24px;
    color: #ccc;
    cursor: pointer;
}

.star:hover,
.star.active {
    color: #ffc107; /* Color when hovered or selected */
}

#selected-rating {
    margin-left: 10px;
    font-size: 16px;
    color: #333;
}

/* Ratings list */
#ratings-list {
    margin-top: 20px;
}

#ratings-list div {
    margin-bottom: 10px;
    font-size: 16px;
    color: white;
}
.rating {
        unicode-bidi: bidi-override;
        direction: rtl;
        text-align: center;
    }
    .rating span.star {
        font-size: 30px;
        color: #ddd;
        cursor: pointer;
    }
    .rating span.star.filled {
        color: yellow;
    }
    #rating-section {
        margin-bottom: 20px;
    }
    .rating-container {
        background-color: grey;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .rating-container h3 {
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 20px;
    }

    .rating-stars {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }

    .rating-stars .star {
        font-size: 24px;
        cursor: pointer;
        color: white;
        margin-right: 5px;
    }

    .rating-stars .star:hover {
        color: #ffbf00;
    }

    #selected-rating {
        margin-top: 10px;
    }

    #ratings-list {
        margin-top: 20px;
    }

    #ratings-list div {
        margin-bottom: 5px;
        font-size: 16px;
    }
    .user-rating-container {
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 10px;
    }

    .user-rating-container p {
        margin: 0;
        padding: 5px;
        color: black;
    }
   


    </style>
</head>
<body>
    <header>
        <div class="container">
            <img src="logo1.png" alt="AutoSpa Logo" class="logo" style="position: relative; right: 80px;"> <!-- Added class="logo" to the logo image -->
            <nav>
                <ul>
                    <li><a href="car2.html">Home</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
            <div class="user-menu">
                <img src="user1.png" alt="User Icon" class="user-icon">
                <div class="dropdown-content">
                    <a href="login.php">Login</a>
                    <a href="reg.html">Sign Up</a>
                    <a href="profile.php">Profile</a>
                    <a href="logout.php">Log Out</a>
                </div>
            </div>
        </div>
    </header>
    <section id="hi">
        <div>
        <?php


// Include database connection file
include 'db_connection.php';

// Check if car wash center ID is set in URL parameters
if(isset($_GET['id'])) {
    // Get the car wash center ID
    $carwashId = $_GET['id'];

    // Prepare SQL statement to retrieve car wash center details by ID
    $sql = "SELECT * FROM carwash_owners WHERE id = :carwashId";

    // Prepare the SQL statement with a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind the car wash center ID parameter
    $stmt->bindValue(':carwashId', $carwashId, PDO::PARAM_INT);

    // Execute the prepared statement
    $stmt->execute();

    // Check if a result is found
    if ($stmt->rowCount() > 0) {
        // Fetch the result as an associative array
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Display car wash center details
        $name= $row["name"];
        $facility1=$row['facility1'];
        $facility2=$row['facility2'];
        $facility3=$row['facility3'];
        $facility4=$row['facility4'];
        $rate1=$row['rate1'];
        $rate2=$row['rate2'];
        $rate3=$row['rate3'];
        $rate4=$row['rate4'];
        $map_location=$row['map_location'];
       $service1=$row['service1'];
       $service2=$row['service2'];
       $service3=$row['service3'];
       $service4=$row['service4'];
        $contact=$row['contact'];
        $email=$row['email'];
        $image1 = "uploads/" . $row["image1"];
        $image2 = "uploads/" . $row["image2"];
        $image3 = "uploads/" . $row["image3"];
        $image4 = "uploads/" . $row["image4"];
        // You can display more details as needed
    } else {
        // No result found for the specified car wash center ID
        echo "<p>Car wash center not found</p>";
    }

    // Close the prepared statement
    $stmt = null;
} else {
    // If car wash center ID is not set, display a message
    echo "<p>No car wash center ID specified</p>";
}
// Close database connection
$conn = null;
?>

        <div class="center-heading">
            <h1><?php echo $name; ?></h1>
            <div class="rating-stars" style="color:#ffd700; display: flex; justify-content: center; font-size: 30px; ">
                
                <?php
                    // Calculate the number of filled stars based on the average rating
                    $averageRating = $row['average_rating'];
                    $filledStars = round($averageRating);
                    $emptyStars = 5 - $filledStars;

                    // Display filled stars
                    for ($i = 0; $i < $filledStars; $i++) {
                        echo '&#9733;'; // Filled star Unicode character
                    }

                    // Display empty stars
                    for ($i = 0; $i < $emptyStars; $i++) {
                        echo '&#9734;'; // Empty star Unicode character
                    }
                ?>
            </div>
        </div>
    
    <div class="container">
        <div class="facility-container">
            <h2>Photos</h2>

<div class="slideshow-container">

    <!-- Full-width images with number and caption text -->
    <div class="mySlides fade">
      <div class="numbertext">1 / 3</div>
      <img src="<?php echo $image1; ?>" style="width:100%">
      <div class="text">Caption Text</div>
    </div>
  
    <div class="mySlides fade">
      <div class="numbertext">2 / 4</div>
      <img src="<?php echo $image2; ?>" style="width:100%">
      <div class="text">Caption Two</div>
    </div>
  
    <div class="mySlides fade">
      <div class="numbertext">3 / 4</div>
      <img src="<?php echo $image3; ?>" style="width:100%">
      <div class="text">Caption Three</div>
    </div>
    <div class="mySlides fade">
      <div class="numbertext">4 / 4</div>
      <img src="<?php echo $image4; ?>" style="width:100%">
      <div class="text">Caption Three</div>
    </div>
  
    <!-- Next and previous buttons -->
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
  </div>
  <br>
  
  <!-- The dots/circles -->
  <div style="text-align:center">
    <span class="dot" onclick="currentSlide(1)"></span>
    <span class="dot" onclick="currentSlide(2)"></span>
    <span class="dot" onclick="currentSlide(3)"></span>
    <span class="dot" onclick="currentSlide(4)"></span>
  </div>

           
                <div class="facility-container">
                    <h2>0ur Services</h2>
                    <div class="facility">
                      <!-- Update facility boxes to include data-service attribute -->
                     <div class="facility-box" data-service="exterior">
    <img src="exterior.jpg" alt="Exterior Wash">
    <p><?php echo $facility1; ?></p>
    <p><mark style="background-color: orange; color:white;"><?php echo $rate1; ?></mark></p>
                    </div>
                    <div class="facility-box" data-service="interior">
    <img src="interior.jpeg" alt="Interior Wash">
    <p><?php echo $facility2; ?></p>
    <p><mark style="background-color: orange; color:white;"><?php echo $rate2; ?></mark></p>
                    </div>
         <div class="facility-box" data-service="oil">
                <img src="oil change.jpg" alt="Oil Change">
    <p><?php echo $facility3; ?></p>
    <p><mark style="background-color: orange; color:white;"><?php echo $rate3; ?></mark></p>
</div>
<div class="facility-box" data-service="engine">
    <img src="eng.jpg" alt="Engine Cleaning">
    <p><?php echo $facility4; ?></p>
    <p><mark style="background-color: orange; color:white;"><?php echo $rate4; ?></mark></p>
</div>

                    </div>
                </div>
                <div class="service-details-container">
                    <h2>Facilities</h2>
                    <div class="service-details" id="exterior-details">
                        <div class="service">
                            <div class="service-container">
                                <h3><?php echo $facility1; ?></h3>
                                <p><?php echo $service1; ?></p>
                                
                                <p><?php echo $rate1; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="service-details" id="interior-details">
                        <div class="service">
                            <div class="service-container">
                                <h3><?php echo $facility2; ?></h3>
                                <p><?php echo $service2; ?></p>
                                <p><?php echo $rate2; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="service-details" id="oil-details">
                        <div class="service">
                            <div class="service-container">
                                <h3><?php echo $facility3; ?></h3>
                                <p><?php echo $service3; ?></p>
                                <p><?php echo $rate3; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="service-details" id="engine-details">
                        <div class="service">
                            <div class="service-container">
                                <h3><?php echo $facility4; ?></h3>
                                <p><?php echo $service4; ?></p>
                                <p><?php echo $rate4; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                    <h2>Contact</h2>
                    <button class="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" viewBox="0 0 32 32" height="32" fill="none" class="svg-icon"><path stroke-width="2" stroke-linecap="round" stroke="#fff" fill-rule="evenodd" d="m24.8868 19.1288c-1.0274-.1308-2.036-.3815-3.0052-.7467-.7878-.29-1.6724-.1034-2.276.48-.797.8075-2.0493.9936-2.9664.3258-1.4484-1.055-2.7233-2.3295-3.7783-3.7776-.6681-.9168-.4819-2.1691.3255-2.9659.5728-.6019.7584-1.4748.4802-2.2577-.3987-.98875-.6792-2.02109-.8358-3.07557-.2043-1.03534-1.1138-1.7807-2.1694-1.77778h-3.18289c-.60654-.00074-1.18614.25037-1.60035.69334-.40152.44503-.59539 1.03943-.53345 1.63555.344 3.31056 1.47164 6.49166 3.28961 9.27986 1.64878 2.5904 3.84608 4.7872 6.43688 6.4356 2.7927 1.797 5.9636 2.9227 9.2644 3.289h.1778c.5409.0036 1.0626-.2 1.4581-.569.444-.406.6957-.9806.6935-1.5822v-3.1821c.0429-1.0763-.7171-2.0185-1.7782-2.2046z" clip-rule="evenodd"></path></svg>
                    
                      </button><p><?php echo $contact; ?></p>
                      <p><?php echo $email; ?></p><br><br>
                      
                     
                    
                      <a href="slot.php?id=<?php echo $carwashId; ?>" class="btn">Book Slot</a>



        


        <div class="map-container">
            <h2>Location</h2>
            <div id="mapid"></div>
        </div>
        <div class="rating-container">
        <div id="rating-section">
    <div id="rating-section">
    <h1 style="text-align: center;" >Rate this car wash:</h1>
    <div class="rating-stars" style="display: flex; justify-content: center; font-size: 30px;">
        <span class="star" data-rating="1">&#9733;</span>
        <span class="star" data-rating="2">&#9733;</span>
        <span class="star" data-rating="3">&#9733;</span>
        <span class="star" data-rating="4">&#9733;</span>
        <span class="star" data-rating="5">&#9733;</span>
        <p id="selected-rating"></p>
        <?php 
        if (isset($_SESSION['username'])) {
        echo '<input type="hidden" name="carwash_id" value="' . $_GET['id'] . '">';
        echo '<input type="hidden" id="username" value="' . $_SESSION['username'] . '">';
    } else {
        echo '';
    }
?>
    </div>

    <?php
    
    include 'db_connection.php'; // Include database connection file

    // Get the car wash center ID from the URL parameters
    if (isset($_GET['id'])) {
        $carwashId = $_GET['id'];

        // Check if the user is logged in
        if (isset($_SESSION['username'])) {
            // Check if the user has already rated this car wash and get the most recent rating
            $stmt = $conn->prepare("SELECT rating FROM ratings WHERE carwash_id = ? AND username = ? ORDER BY id DESC LIMIT 1");
            $stmt->execute([$carwashId, $_SESSION['username']]);
            $userRating = $stmt->fetch(PDO::FETCH_ASSOC);

            // Display the rating for the user
            if ($userRating) {
                echo '<p>Your rating: ' . $userRating['rating'] . ' stars</p>';
            } else {
                echo '<p>You have not rated this car wash yet.</p>';
            }
        } else {
            // If the user is not logged in, prompt them to log in to rate
            echo '<h2>Please <a href="login.php">login</a> to rate this car wash.</h2>';
        }
    } else {
        // If car wash center ID is not set, display a message
        echo "<p>No car wash center ID specified</p>";
    }

    // Close the database connection
    $conn = null;
    ?>

</div>

<div id="ratings-list">
    <?php
    include 'db_connection.php'; // Include database connection file

    // Get ratings and usernames from the database for the specific car wash
    if (isset($_GET['id'])) {
        $carwashId = $_GET['id'];
        $stmt = $conn->prepare("SELECT username, rating FROM ratings WHERE id IN (SELECT MAX(id) FROM ratings WHERE carwash_id = ? GROUP BY username)");
        $stmt->execute([$carwashId]);
        $ratings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display ratings
        foreach ($ratings as $rating) {
            echo "<div class='user-rating-container'>";
            echo "<p>{$rating['username']}</p>"; // Username
            echo "<p>{$rating['rating']} stars</p>"; // Rating
            echo "</div>";
        }
    } else {
        // If car wash center ID is not set, display a message
        echo "<p>No car wash center ID specified</p>";
    }

    // Close the database connection
    $conn = null;
    ?>
</div>
</div>


   

    </section>
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('mapid').setView([9.939093, 76.271461], 13); // Coordinates and zoom level

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker([9.939093, 76.271461]).addTo(map)
            .bindPopup('<?php echo $map_location; ?>')
            .openPopup();
    </script>
    <script>
        let slideIndex = 0;
showSlides();

function showSlides() {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  slides[slideIndex-1].style.display = "block";
  setTimeout(showSlides, 2000); // Change image every 2 seconds
}
document.addEventListener('DOMContentLoaded', function() {
            const usernameElement = document.getElementById('username');
            if (usernameElement) {
                const username = usernameElement.value;
                const stars = document.querySelectorAll('.star');
                const ratingOutput = document.getElementById('selected-rating');

                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const rating = this.dataset.rating;
                        ratingOutput.innerText = `You rated this car wash ${rating} stars!`;
                        sendRatingToServer(rating, username);
                    });
                });
            }
        });

        function sendRatingToServer(rating, username) {
    const xhr = new XMLHttpRequest();
    // Get the value of 'id' parameter from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const carwashId = urlParams.get('id');

    xhr.open('POST', 'process_rating.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log('Rating sent successfully');
            // Update the rating-info element with the rating and username
            document.getElementById('rating-info').innerHTML = `You rated this car wash ${rating} stars as ${username}!`;
        } else {
            console.error('Error sending rating');
        }
    };
    xhr.send(`rating=${rating}&carwash_id=${carwashId}&username=${username}`); // Include username in the request
}









    </script>

    <footer class="footer">
        <p>&copy; 2024 AutoSpa</p>
    </footer>
</body>
</html>

