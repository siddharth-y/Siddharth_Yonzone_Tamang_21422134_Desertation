<?php
session_start(); // Start a new session
include('dbconnect.php'); // Include the 'dbconnect.php' file to establish a database connection.

if (isset($_POST['delete_package'])) {
    $packageId = $_POST['id'];
    
    try {
        // Prepare and execute a database query to select all records from the 'packages' table
        $stmt = $pdo->prepare('DELETE FROM packages WHERE packageId = :packageId');
        $stmt->bindParam(':packageId', $packageId);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Package Successfully Deleted!';
            // Redirect to packages.php using JavaScript
            echo '<script>window.location.href = "packages.php";</script>';
        } else {
            $_SESSION['message'] = 'Error Deleting Package!';
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
}
