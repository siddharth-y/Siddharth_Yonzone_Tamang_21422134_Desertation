<?php
session_start(); // Start a new session
include('dbconnect.php'); // Include the 'dbconnect.php' file to establish a database connection.


if (isset($_POST['delete_accom'])) {
    $hotelId = $_POST['id'];
    
    try {
        $stmt = $pdo->prepare('DELETE FROM hotels WHERE hotelId = :hotelId');
        $stmt->bindParam(':hotelId', $hotelId);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Hotel Successfully Deleted!';
            // Redirect to packages.php using JavaScript
            echo '<script>window.location.href = "accommodation.php";</script>';
        } else {
            $_SESSION['message'] = 'Error Deleting Hotel!';
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
}
