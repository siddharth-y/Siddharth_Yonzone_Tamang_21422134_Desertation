<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');
// Check if a booking ID is passed in the URL
if (isset($_GET['id'])) { // Updated to 'bookingId'
    $bookingId = $_GET['id']; // Updated to 'bookingId'

    // Fetch booking details from the database
    $stmt = $pdo->prepare('SELECT * FROM bookings WHERE bookingId = :bookingId');
    $stmt->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
    $stmt->execute();
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($booking) {
        // Fetch package details
        $stmt = $pdo->prepare('SELECT * FROM packages WHERE packageId = :packageId');
        $stmt->bindParam(':packageId', $booking['packageId'], PDO::PARAM_INT);
        $stmt->execute();
        $package = $stmt->fetch(PDO::FETCH_ASSOC);

        // Fetch hotel details
        $stmt = $pdo->prepare('SELECT * FROM hotels WHERE hotelId = :hotelId');
        $stmt->bindParam(':hotelId', $booking['hotelId'], PDO::PARAM_INT);
        $stmt->execute();
        $hotel = $stmt->fetch(PDO::FETCH_ASSOC);

        // Fetch transportation details
        $stmt = $pdo->prepare('SELECT * FROM transportations WHERE vehicleId = :vehicleId');
        $stmt->bindParam(':vehicleId', $booking['vehicleId'], PDO::PARAM_INT);
        $stmt->execute();
        $transportation = $stmt->fetch(PDO::FETCH_ASSOC);

        // Display the booking details
?>

        <script src="assets/js/pdf.js"></script>
        <main id="main" class="scrolled-offset">
            <!--  HTML structure to display booking details here -->
            <section id="booking-details" class="booking-details">
                <div class="container">
                    <h2>Booking Details</h2>
                    <div class="card">
                        <div class="card-body">
                            <table class="table" id="booking-details-table">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Package Name:</strong></td>
                                        <td><?php echo $package['packageName']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>No. Of Days:</strong></td>
                                        <td><?php echo $package['noOfDays']; ?> days</td>
                                    </tr>
                                    <!-- Check if the 'number_of_person' key exists before accessing it -->
                                    <tr>
                                        <td><strong>Number of Persons:</strong></td>
                                        <td><?php echo isset($booking['number_of_persons']) ? $booking['number_of_persons'] : 'N/A'; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Name:</strong></td>
                                        <td><?php echo $booking['customerName']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td><?php echo $booking['customerEmail']; ?></td>
                                    </tr>
                                    <!-- Check if the 'customerContact' key exists before accessing it -->
                                    <tr>
                                        <td><strong>Contact:</strong></td>
                                        <td><?php echo isset($booking['customerContact']) ? $booking['customerContact'] : 'N/A'; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Selected Hotel:</strong></td>
                                        <td><?php echo $hotel['hotelName']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Transportation Vehicle:</strong></td>
                                        <td><?php echo $transportation['vehicleName']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Additional Notes:</strong></td>
                                        <td><?php echo $booking['additional_notes']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Start Date:</strong></td>
                                        <td><?php echo $booking['startDate']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Package Cost:</strong></td>
                                        <td>$<?php echo $package['packageCost']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Hotel Cost:</strong></td>
                                        <td>$<?php echo $hotel['hotelCost']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Vehicle Cost:</strong></td>
                                        <td>$<?php echo $transportation['vehicleCost']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Cost:</strong></td>
                                        <td>$<?php
                                                // Calculate the total cost by adding package cost, hotel cost, and vehicle cost
                                                $totalCost = $package['packageCost'] + $hotel['hotelCost'] + $transportation['vehicleCost'];
                                                echo $totalCost;
                                                ?>
                                        </td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
                <div class="text-center mt-4">
                    <button class="btn btn-primary" id="downloadButton">Download PDF</button>
                    <button class="btn btn-primary" id="printButton">Print</button>
                </div>
            </section>
        </main>

<?php
    } else {
        echo "<p>Booking not found.</p>";
    }
} else {
    echo "<p>Missing booking ID. Please provide a valid booking ID.</p>";
}

?>


<script>
    // Function to print the booking details table
    function printBookingDetails() {
        const printWindow = window.open('', '', 'width=800,height=600');

        // printWindow.document.write('<html><head><title>Booking Details</title></head><body>');
        printWindow.document.write('<div style="text-align: center;"><img src="assets/img/logo.jpg" width="100"></div>');
        printWindow.document.write('<h2 style="text-align: center; margin-top: 10px;">Booking Details</h2>');

        // Print only the booking details table
        const tableContent = document.getElementById('booking-details-table').outerHTML;
        printWindow.document.write(tableContent);

        printWindow.document.close();

        // Delay the print action by a few milliseconds
        setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 100); // You can adjust the delay as needed
    }

    // Add click event listener to the print button
    document.getElementById('printButton').addEventListener('click', printBookingDetails);
</script>


<style>
    /* Table styles for screen */
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        border: 1px solid #000;
        /* Add border styles for table headers and data cells */
        padding: 8px;
        /* Add padding for better spacing */
    }

    /* Table styles for print */
    @media print {
        table {
            border-collapse: collapse;
            width: 100%;
            page-break-inside: auto;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            page-break-inside: avoid;
            page-break-after: auto;
        }
    }
</style>