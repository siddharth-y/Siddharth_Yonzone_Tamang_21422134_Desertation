<?php
session_start();
include('dbconnect.php');

if (isset($_POST['delete_transpo'])) {
    $vehicleId = $_POST['id'];
    
    try {
        $stmt = $pdo->prepare('DELETE FROM transportations WHERE vehicleId = :vehicleId');
        $stmt->bindParam(':vehicleId', $vehicleId);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Vehicle Successfully Deleted!';
            // Redirect to packages.php using JavaScript
            echo '<script>window.location.href = "transportation.php";</script>';
        } else {
            $_SESSION['message'] = 'Error Deleting Vehicle!';
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
}
?>
