<?php
session_start();
// Include necessary files and database connection
include_once('layout/header.php'); // Include the 'header.php' file, which contains the HTML header section of the website.
include_once('layout/navigation.php'); // Include the 'navigation.php' file, which contains the website's navigation menu.
include_once('admin/dbconnect.php'); // Include the 'dbconnect.php' file to establish a database connection.

if (isset($_GET['id'])) {
    $packageId = $_GET['id'];

    // Validate the package ID
    if (!is_numeric($packageId) || $packageId <= 0) {
        echo "<p>Invalid package ID. Please provide a valid package ID.</p>";
        // You can choose to exit or redirect to an error page here.
    } else {
        // Fetch the trekking details from the database using the ID
        $stmt = $pdo->prepare('SELECT * FROM packages WHERE packageId = :id');
        $stmt->bindParam(':id', $packageId, PDO::PARAM_INT);
        $stmt->execute();
        $trekking = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($trekking) {
            // Display the trekking details and the booking form
?>

            <main id="main" class="scrolled-offset">
                <!-- ======= Breadcrumbs ======= -->
                <section id="breadcrumbs" class="breadcrumbs">
                    <div class="container">
                        <ol>
                            <li><a href="index.php">Home</a></li>
                            <li>Booking</li>
                        </ol>
                        <h2>Booking</h2>
                    </div>
                </section><!-- End Breadcrumbs -->

                <!-- ======= Package Card Section ======= -->
                <section id="package-card" class="package-card">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4">
                                <!-- Display package information  -->
                                <div class="package-info">
                                    <!-- Fetch package name form array $trekking -->
                                    <h3><?php echo $trekking['packageName']; ?></h3>
                                    <ul>
                                        <!-- Fetch number of days form array $trekking -->
                                        <li><strong>No. Of Days</strong>: <?php echo $trekking['noOfDays']; ?> days</li>
                                        <!-- Fetch package difficulty form array $trekking -->
                                        <li><strong>Difficulty</strong>: <?php echo $trekking['packageDifficulty']; ?></li>
                                        <!-- Fetch package cost form array $trekking -->
                                        <li><strong>Trek Cost</strong>: $<?php echo $trekking['packageCost']; ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section><!-- End Package Card Section -->

                <!-- ======= Booking Form Section ======= -->
                <section id="booking-form" class="booking-form">
                    <div class="container">
                        <h2>Booking Form</h2>
                        <form action="process_booking.php" method="post">
                            <!-- Fetch Package id for booking form -->
                            <input type="hidden" name="package_id" value="<?php echo $packageId; ?>">
                            <!-- Fetch Package name for booking form -->
                            <input type="hidden" name="package_name" value="<?php echo $trekking['packageName']; ?>">
                            <!-- Fetch Package cost for booking form -->
                            <input type="hidden" name="package_cost" value="<?php echo $trekking['packageCost']; ?>">
                            <!-- Form for user to fill -->
                            <div class="form-group">
                                <label for="full_name">Full Name:</label>
                                <input type="text" name="full_name" id="full_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="contact">Contact:</label>
                                <input type="text" name="contact" id="contact" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="number_of_persons">Number of Persons:</label>
                                <input type="number" name="number_of_persons" id="number_of_persons" class="form-control" value="1" required>
                            </div>
                            <div class="form-group">
                                <label for="start_date">Start Date:</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" required>
                            </div>
                            <input type="hidden" name="booking_date" id="booking_date" value="<?php echo date('Y-m-d'); ?>">
                            <div class="form-group">
                                <label for="additional_notes">Additional Notes:</label>
                                <textarea name="additional_notes" id="additional_notes" class="form-control" rows="4"></textarea>
                            </div>

                            <!-- Hotel Selection -->
                            <div class="form-group">
                                <label for="selected_hotel">Select Hotel:</label>
                                <div class="hotel-options">
                                    <?php
                                    // Fetch hotel options from the database and create radio buttons
                                    $hotelOptions = $pdo->query('SELECT * FROM hotels')->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($hotelOptions as $option) {
                                        // Use unique IDs for each radio button and corresponding labels
                                        $optionId = 'hotel_option_' . $option['hotelId'];
                                    ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="selected_hotel" id="<?php echo $optionId; ?>" value="<?php echo $option['hotelId']; ?>">
                                            <label class="form-check-label" for="<?php echo $optionId; ?>">
                                                <img style="width: 100px;" src="admin/assets/img/acco/<?php echo $option['hotelImg']; ?>" alt="<?php echo $option['hotelName']; ?> " class="option-image">
                                                <?php echo $option['hotelName']; ?> - $<?php echo $option['hotelCost']; ?>
                                            </label>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>

                            <!-- Vehicle Selection -->
                            <div class="form-group">
                                <label for="selected_vehicle">Select Vehicle:</label>
                                <div class="vehicle-options">
                                    <?php
                                    // Fetch vehicle options from the database and create radio buttons
                                    $vehicleOptions = $pdo->query('SELECT * FROM transportations')->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($vehicleOptions as $option) {
                                        // Use unique IDs for each radio button and corresponding labels
                                        $optionId = 'vehicle_option_' . $option['vehicleId'];
                                    ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="selected_vehicle" id="<?php echo $optionId; ?>" value="<?php echo $option['vehicleId']; ?>">
                                            <label class="form-check-label" for="<?php echo $optionId; ?>">
                                                <img style="width: 100px;" src="admin/assets/img/transpo/<?php echo $option['vehicleImg']; ?>" alt="<?php echo $option['vehicleName']; ?> " class="option-image">
                                                <?php echo $option['vehicleName']; ?> - $<?php echo $option['vehicleCost']; ?>
                                            </label>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <!-- End Vehicle Selection -->

                            <button type="submit" name="submit" class="btn btn-primary">Submit Booking</button>
                        </form>
                    </div>
                </section><!-- End Booking Form Section -->
            </main><!-- End #main -->
<?php
        } else {
            echo "<p>Trekking not found.</p>";
        }
    }
} else {
    echo "<p>Missing package ID. Please provide a valid package ID.</p>";
}

include_once('layout/footer.php'); // Include the 'footer.php' file, which likely contains the HTML footer section of the website.
?>