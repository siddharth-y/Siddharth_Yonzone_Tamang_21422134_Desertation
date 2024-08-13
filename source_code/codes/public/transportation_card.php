<?php
// Include necessary files and database connection
include_once('admin/dbconnect.php'); // Include the 'dbconnect.php' file to establish a database connection.
include_once('layout/functions.php'); // Include the 'navigation.php' file, which contains the website's navigation menu.
$i = 0;
try {
    // Prepare and execute a database query to select all records from the 'transportation' table
    $stmt = $pdo->prepare('SELECT * FROM transportations');
    $stmt->execute();
    $transportations = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as an associative array.
} catch (PDOException $e) {
    die("Error: " . $e->getMessage()); // Handle any database connection errors.
}
// display 3 transportation card in a row
$transportationCount = count($transportations);
for ($i = 0; $i < $transportationCount; $i++) {
    if ($i % 3 == 0) {
        echo '<div class="row">';
    }

    $transportation = $transportations[$i];
    echo '<div class="col-md-4 mb-4">';
    echo '<div class="card">';
    // getting transportation id
    echo '<a href="transportationDetail.php?id=' . $transportation['vehicleId'] . '">';
    // Getting vehicle image from table
    echo '<img class="card-img-top" src="admin/assets/img/transpo/' . $transportation['vehicleImg'] . '" alt="vehicle image">';
    echo '</a>';
    echo '<div class="card-body">';
    // Getting vehical name 
    echo '<h5 class="card-title">' . $transportation['vehicleName'] . '</h5>';
    // Getting vehicle description in short form
    echo '<p class="card-text transportation-description">' . shortenText($transportation['vehicleDescription'], 50) . '</p>';
    echo '<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</a>';

    $i++; // Increment $i

    if ($i % 3 == 0 || $i == count($transportations)) {
        echo '</div>'; // Close the row after every three transportation options or at the end
    }
}
