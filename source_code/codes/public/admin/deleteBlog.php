<?php
session_start();
include('dbconnect.php');

if (isset($_POST['delete_blog'])) {
    $blogId = $_POST['id'];
    
    try {
        $stmt = $pdo->prepare('DELETE FROM blogs WHERE blogId = :blogId');
        $stmt->bindParam(':blogId', $blogId);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Blog Successfully Deleted!';
            // Redirect to packages.php using JavaScript
            echo '<script>window.location.href = "blogs.php";</script>';
        } else {
            $_SESSION['message'] = 'Error Deleting Blog!';
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
}
?>
