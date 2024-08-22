<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Wash Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('search1.jpg'); /* Adjust the URL to your image */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .overlay {
            background-color: rgba(0, 0, 0, 0.5);
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .container {
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        li a {
            color: #333;
            text-decoration: none;
            font-weight: bold;
        }
        li a:hover {
            color: #007bff;
        }
        p {
            font-size: 18px;
            font-weight: bold;
            color: white;
            margin-bottom: 20px;
        }
        .container {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    overflow: hidden;
}

.image-container {
    width: 100%;
    height: 200px; /* Adjust height as needed */
    overflow: hidden;
}

.image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.details {
    padding: 20px;
}

.details h3 {
    font-size: 24px;
    margin-bottom: 10px;
}

.details .location {
    font-size: 16px;
    color: #666;
    margin-bottom: 20px;
}

.details a {
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
}

.details a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    <div class="overlay"><?php
include 'db_connection.php';

if(isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    echo "<p>Showing results for: '$searchQuery'</p>";
    $sql = "SELECT * FROM carwash_owners WHERE approved = 1 AND (name LIKE :searchQuery OR district LIKE :searchQuery)";
    $stmt = $conn->prepare($sql);
    $param = "%$searchQuery%";
    $stmt->bindParam(':searchQuery', $param);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        foreach($result as $row) {
            echo "<div class='container'>";
            // Check if image1 column is not empty
            if (!empty($row['image1'])) {
                echo "<div class='image-container'>";
                echo "<img src='" . $row['image1'] . "' alt='Car Wash Image'>";
                echo "</div>";
            } else {
                echo "<div class='image-container'>";
                echo "No image available";
                echo "</div>";
            }
            echo "<div class='details'>";
            echo "<h3>".$row['name']."</h3>";
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
            echo "<p class='location'>Location: ".$row['district']."</p>";
            echo "<a href='carwash-details.php?id=".$row['id']."'>View Details</a>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>No results found for '$searchQuery'</p>";
    }

} else {
    echo "<p>No search query specified</p>";
}

$stmt = null;
$conn = null;
?> </div>
</body>
</html>
