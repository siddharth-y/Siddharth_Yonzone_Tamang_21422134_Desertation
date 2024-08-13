<?php
session_start();
// Include necessary files and database connection
include_once('admin/dbconnect.php');

if (isset($_POST['submit'])) {
    // Retrieve form data
    $packageId = $_POST['package_id'];
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $startDate = $_POST['start_date'];
    $bookingDate = $_POST['booking_date']; // This will be the current date
    $numberOfPersons = $_POST['number_of_persons']; // Corrected column name

    // Retrieve selected hotel ID
    if (isset($_POST['selected_hotel'])) {
        $selectedHotelId = $_POST['selected_hotel'];

        // Fetch selected hotel information from the database
        $stmt = $pdo->prepare('SELECT * FROM hotels WHERE hotelId = :hotelId');
        $stmt->bindParam(':hotelId', $selectedHotelId, PDO::PARAM_INT);
        $stmt->execute();
        $hotel = $stmt->fetch(PDO::FETCH_ASSOC);
        $hotelCost = $hotel['hotelCost'];
    } else {
        // Handle the case where no hotel is selected
        $_SESSION['booking_alert'] = 'Error: Please select a hotel.';
        header('Location: booking.php'); // Redirect back to the booking page
        exit();
    }

    // Retrieve selected vehicle ID
    if (isset($_POST['selected_vehicle'])) {
        $selectedVehicleId = $_POST['selected_vehicle'];

        // Fetch selected vehicle information from the database
        $stmt = $pdo->prepare('SELECT * FROM transportations WHERE vehicleId = :vehicleId');
        $stmt->bindParam(':vehicleId', $selectedVehicleId, PDO::PARAM_INT);
        $stmt->execute();
        $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);
        $vehicleCost = $vehicle['vehicleCost'];
    } else {
        // Handle the case where no vehicle is selected
        $_SESSION['booking_alert'] = 'Error: Please select a vehicle.';
        header('Location: booking.php'); // Redirect back to the booking page
        exit();
    }

    // Retrieve the package cost based on the selected package ID
    $stmt = $pdo->prepare('SELECT packageCost FROM packages WHERE packageId = :packageId');
    $stmt->bindParam(':packageId', $packageId, PDO::PARAM_INT);
    $stmt->execute();
    $package = $stmt->fetch(PDO::FETCH_ASSOC);
    $packageCost = $package['packageCost'];

    // Calculate the total cost based on the retrieved costs
    $totalCost = $packageCost + $hotelCost + $vehicleCost;

    // Insert the data into the bookings table, including the total cost
    $stmt = $pdo->prepare('INSERT INTO bookings (customerName, customerEmail, customerContact, number_of_persons, bookingDate, packageId, hotelId, vehicleId, startDate, totalCost, additional_notes) 
                            VALUES (:customerName, :customerEmail, :customerContact, :number_of_persons, :bookingDate, :packageId, :hotelId, :vehicleId, :startDate, :totalCost, :additional_notes)');
    $stmt->bindParam(':customerName', $fullName, PDO::PARAM_STR);
    $stmt->bindParam(':customerEmail', $email, PDO::PARAM_STR);
    $stmt->bindParam(':customerContact', $contact, PDO::PARAM_STR);
    $stmt->bindParam(':number_of_persons', $numberOfPersons, PDO::PARAM_INT);
    $stmt->bindParam(':bookingDate', $bookingDate, PDO::PARAM_STR);
    $stmt->bindParam(':packageId', $packageId, PDO::PARAM_INT);
    $stmt->bindParam(':hotelId', $selectedHotelId, PDO::PARAM_INT);
    $stmt->bindParam(':vehicleId', $selectedVehicleId, PDO::PARAM_INT);
    $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
    $stmt->bindParam(':totalCost', $totalCost, PDO::PARAM_INT); // Bind the calculated total cost
    $additionalNotes = $_POST['additional_notes'];
    $stmt->bindParam(':additional_notes', $additionalNotes, PDO::PARAM_STR);

    if ($stmt->execute()) {
        // Booking successfully inserted into the database
        $bookingId = $pdo->lastInsertId(); // Get the last inserted booking ID

        $_SESSION['booking_alert'] = 'Booking successful!';
        header('Location: booking_success.php?bookingId=' . $bookingId); // Redirect to a confirmation page
        exit();
    } else {
        // Handle the case where the booking could not be inserted
        $_SESSION['booking_alert'] = 'Error: Booking failed.';
        header('Location: booking.php'); // Redirect back to the booking page
        exit();
    }
} else {
    // Handle the case where the form was not submitted
    $_SESSION['booking_alert'] = 'Error: Form submission failed.';
    header('Location: booking.php'); // Redirect back to the booking page
    exit();

}
