<?php
// Include necessary files and database connection
include_once('admin/dbconnect.php'); // Including database connection 
include_once('layout/functions.php'); //Inclding function to shortern desciption

try {
    // Prepare and execute a database query to select all hotels and its content
    $stmt = $pdo->prepare('SELECT * FROM hotels');
    $stmt->execute();
    $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as an associative array.
} catch (PDOException $e) {
    die("Error: " . $e->getMessage()); // Handle any database connection errors.
}

// hotelcount has hotels array 
$hotelCount = count($hotels);

for ($i = 0; $i < $hotelCount; $i++) {
    if ($i % 3 == 0) {
        echo '<div class="row">';
    }

    $hotel = $hotels[$i];

    echo '<div class="col-md-4 mb-4">';
    echo '<div class="card">';
    // This calls hotel id
    echo '<a href="accommodationDetail.php?id=' . $hotel['hotelId'] . '">';
    // This calls images if hotel form array
    echo '<img class="card-img-top" src="admin/assets/img/acco/' . $hotel['hotelImg'] . '" alt="hotel image">';
    echo '</a>';
    echo '<div class="card-body">';
    // This calls name of hotel form array
    echo '<h5 class="card-title">' . $hotel['hotelName'] . '</h5>';
    // This calls description of hotel form array
    echo '<p class="card-text package-description">' . shortenText($hotel['hotelDescription'], 50) . '</p>';
    echo '<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    if ($i % 3 == 2 || $i == $hotelCount - 1) {
        echo '</div>'; // Close the row after every three hotels or at the end
    }
}
