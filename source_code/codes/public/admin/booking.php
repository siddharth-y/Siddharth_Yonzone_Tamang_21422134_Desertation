<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Fetch both bookings and their associated package names
$bookings = $pdo->query('SELECT bookings.*, packages.packageName FROM bookings
                        LEFT JOIN packages ON bookings.packageId = packages.packageId');

?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Booking Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Bookings</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <?php if (isset($_SESSION['message'])) {
                    echo ' <h5 class="alert alert-success">' . $_SESSION['message'] . '</h5>';
                    unset($_SESSION['message']); // Clear the session message
                } ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Booking Table</h5>
                        <p>Add Bookins, edit, view and delet. Also can confirm Bookings</p>
                        <a href="addBooking.php"><button type="button" class="btn btn-success">Add</button></a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Package Name</th>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Customer Email</th>
                                    <th scope="col">Booking Date</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">Total Cost</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($bookings as $booking) {
                                    echo '<tr>';
                                    echo '<td>' . (isset($booking['packageName']) ? $booking['packageName'] : 'N/A') . '</td>';
                                    echo '<td>' . $booking['customerName'] . '</td>';
                                    echo '<td>' . $booking['customerEmail'] . '</td>';
                                    echo '<td>' . $booking['bookingDate'] . '</td>';
                                    echo '<td>' . $booking['startDate'] . '</td>';
                                    echo '<td>$' . $booking['totalCost'] . '</td>';
                                    echo '<td>';

                                    // Check if the status is "Approved" or "Pending" and display the appropriate button
                                    if ($booking['status'] == 'Approved') {
                                        echo '<span class="badge bg-success">Approved</span>';
                                    } else {
                                        echo '<div class="mb-1"> <span class="badge bg-warning">Pending</span></div>';
                                        echo '<a href="confirmBooking.php?id=' . $booking['bookingId'] . '" class="btn btn-success bi bi-check-circle me-2"></a>';
                                    }
                                    echo '<a href="viewBooking.php?id=' . $booking['bookingId'] . '" class="btn btn-primary bi bi-eye me-2"></a>';
                                    echo '<a href="editBooking.php?id=' . $booking['bookingId'] . '" class="btn btn-primary bi bi-pencil-square me-2"></a>';
                                    echo '<form method="post" action="deleteBooking.php" style="display: inline;">
                                    <input type="hidden" name="id" value="' . $booking['bookingId'] . '" />
                                    <button type="submit" name="delete_booking" value="' . $booking['bookingId'] . '" class="btn btn-danger bi bi-trash"></button>
                                </form>';
                                    echo '</td>';
                                    echo '</tr>';
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
include('layouts/footer.php')
?>
<script>
    // Automatically hide the alert message after 3 seconds
    setTimeout(function() {
        document.querySelector('.alert').style.display = 'none';
    }, 3000);
</script>