<?php
session_start();
include('dbconnect.php');

if (isset($_POST['delete_user'])) {
    $userId = $_POST['id'];

    try {
        $stmt = $pdo->prepare('DELETE FROM users WHERE userId = :userId');
        $stmt->bindParam(':userId', $userId);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'User Successfully Deleted!';
            // Redirect to packages.php using JavaScript
            echo '<script>window.location.href = "users.php";</script>';
        } else {
            $_SESSION['message'] = 'Error Deleting Users!';
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
}
