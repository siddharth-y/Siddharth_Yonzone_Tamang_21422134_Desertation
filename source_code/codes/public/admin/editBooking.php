<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

if (isset($_POST['update_booking'])) {
    $bookingId = $_POST['booking_id'];
    $customerName = $_POST['customer_name'];
    $customerEmail = $_POST['customer_email'];
    $customerContact = $_POST['customer_contact'];
    $numberOfPersons = $_POST['number_of_persons'];
    $bookingDate = $_POST['booking_date'];
    $packageId = $_POST['package_id'];
    $hotelId = $_POST['hotel_id'];
    $vehicleId = $_POST['vehicle_id'];
    $startDate = $_POST['start_date'];
    $totalCost = $_POST['total_cost'];
    $additionalNotes = $_POST['additional_notes'];

    // Perform the update query
    $stmt = $pdo->prepare('UPDATE bookings 
                           SET customerName = :customerName, 
                               customerEmail = :customerEmail, 
                               customerContact = :customerContact, 
                               number_of_persons = :numberOfPersons, 
                               bookingDate = :bookingDate, 
                               packageId = :packageId, 
                               hotelId = :hotelId, 
                               vehicleId = :vehicleId, 
                               startDate = :startDate, 
                               totalCost = :totalCost, 
                               additional_notes = :additionalNotes 
                           WHERE bookingId = :bookingId');

    $stmt->bindParam(':customerName', $customerName, PDO::PARAM_STR);
    $stmt->bindParam(':customerEmail', $customerEmail, PDO::PARAM_STR);
    $stmt->bindParam(':customerContact', $customerContact, PDO::PARAM_STR);
    $stmt->bindParam(':numberOfPersons', $numberOfPersons, PDO::PARAM_INT);
    $stmt->bindParam(':bookingDate', $bookingDate, PDO::PARAM_STR);
    $stmt->bindParam(':packageId', $packageId, PDO::PARAM_INT);
    $stmt->bindParam(':hotelId', $hotelId, PDO::PARAM_INT);
    $stmt->bindParam(':vehicleId', $vehicleId, PDO::PARAM_INT);
    $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
    $stmt->bindParam(':totalCost', $totalCost, PDO::PARAM_INT);
    $stmt->bindParam(':additionalNotes', $additionalNotes, PDO::PARAM_STR);
    $stmt->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Booking updated successfully.';
        header('Location: booking.php');
        exit();
    } else {
        $_SESSION['message'] = 'Error updating booking.';
        header('Location: booking.php?id=' . $bookingId);
        exit();
    }
} else {
    // Check if a booking ID is provided
    if (isset($_GET['id'])) {
        $bookingId = $_GET['id'];

        // Fetch the booking information
        $stmt = $pdo->prepare('SELECT * FROM bookings WHERE bookingId = :bookingId');
        $stmt->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
        $stmt->execute();
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$booking) {
            $_SESSION['message'] = 'Booking not found.';
            header('Location: booking.php');
            exit();
        }
    } else {
        $_SESSION['message'] = 'Booking ID not provided.';
        header('Location: booking.php');
        exit();
    }
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Booking</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item"><a href="bookings.php">Bookings</a></li>
                <li class="breadcrumb-item active">Edit Booking</li>
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
                        <h5 class="card-title">Edit Booking</h5>
                        <form action="editBooking.php" method="post">
                            <input type="hidden" name="booking_id" value="<?php echo $bookingId; ?>">
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Customer Name</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo $booking['customerName']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="customer_email" class="form-label">Customer Email</label>
                                <input type="email" class="form-control" id="customer_email" name="customer_email" value="<?php echo $booking['customerEmail']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="customer_contact" class="form-label">Customer Contact</label>
                                <input type="text" class="form-control" id="customer_contact" name="customer_contact" value="<?php echo $booking['customerContact']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="number_of_persons" class="form-label">Number of Persons</label>
                                <input type="number" class="form-control" id="number_of_persons" name="number_of_persons" value="<?php echo $booking['number_of_persons']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="booking_date" class="form-label">Booking Date</label>
                                <input type="date" class="form-control" id="booking_date" name="booking_date" value="<?php echo $booking['bookingDate']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="package_id" class="form-label">Package ID</label>
                                <input type="number" class="form-control" id="package_id" name="package_id" value="<?php echo $booking['packageId']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="hotel_id" class="form-label">Hotel ID</label>
                                <input type="number" class="form-control" id="hotel_id" name="hotel_id" value="<?php echo $booking['hotelId']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="vehicle_id" class="form-label">Vehicle ID</label>
                                <input type="number" class="form-control" id="vehicle_id" name="vehicle_id" value="<?php echo $booking['vehicleId']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $booking['startDate']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="total_cost" class="form-label">Total Cost</label>
                                <input type="number" class="form-control" id="total_cost" name="total_cost" value="<?php echo $booking['totalCost']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="additional_notes" class="form-label">Additional Notes</label>
                                <textarea class="form-control" id="additional_notes" name="additional_notes"><?php echo $booking['additional_notes']; ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" name="update_booking">Update Booking</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include('layouts/footer.php'); ?>
<script>
    // Automatically hide the alert message after 3 seconds
    setTimeout(function() {
        document.querySelector('.alert').style.display = 'none';
    }, 3000);
</script>