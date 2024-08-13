<?php
include('layout/header.php'); // Include the 'header.php' file, which contains the HTML header section of the website.
include('layout/navigation.php'); // Include the 'navigation.php' file, which likely contains the website's navigation menu.
include('admin/dbconnect.php'); // Include the 'dbconnect.php' file to establish a database connection.

// Check if 'id' is set and is a valid number
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch hotel records related to the trekking package using packageId
    $stmt = $pdo->prepare('SELECT * FROM transportations WHERE vehicleId = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $transportation = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single row

    if (!empty($transportation)) { // Check if data exists
        // Display the hotel details
?>
        <main id="main" class="scrolled-offset">
            <!-- ======= Breadcrumbs ======= -->
            <section id="breadcrumbs" class="breadcrumbs">
                <div class="container">
                    <ol>
                        <li><a href="index.php">Home</a></li>
                        <li>Vehicle Details</li>
                    </ol>
                    <h2><?php echo $transportation['vehicleName']; ?></h2>
                </div>
            </section><!-- End Breadcrumbs -->

            <!-- ======= Portfolio Details Section ======= -->
            <section id="portfolio-details" class="portfolio-details">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="portfolio-info">
                                <div class="portfolio-details-slider swiper">
                                    <div class="swiper-wrapper align-items-center">
                                        <div class="swiper-slide">
                                            <!-- This is to call vahicla images from transportation table -->
                                            <?php echo '<img class="card-img-top" src="admin/assets/img/transpo/' . $transportation['vehicleImg'] . '" alt="hotel image">'; ?>
                                        </div>
                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                                <!-- This is to call vehicle name form database -->
                                <h3><?php echo $transportation['vehicleName']; ?></h3>
                                <ul>
                                    <!-- This is to call vehicle type -->
                                    <li><strong>Vehicle Type</strong>: <?php echo $transportation['vehicleType']; ?></li>
                                    <!-- This is to call no of seats in vehicle -->
                                    <li><strong>No. Of Seat</strong>: <?php echo $transportation['noOfSeat']; ?></li>
                                    <!-- this is to call the cost of vehicle -->
                                    <li><strong>Price</strong>: $<?php echo $transportation['vehicleCost']; ?></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="portfolio-description">
                                <h2>Vehicle Detail</h2>
                                <p>
                                    <!-- This is to call description of vehicle -->
                                    <?php echo $transportation['vehicleDescription']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!-- End Portfolio Details Section -->
        </main><!-- End #main -->
        <style>
            /* Add CSS to style the description section */
            .portfolio-description {
                width: 100%;
                text-align: justify;
            }
        </style>
<?php
        // If hotel id is not found then it shows errors
    } else {
        echo "<p>Hotel not found.</p>";
    }
} else {
    echo "<p>Invalid or missing hotel ID.</p>";
}

include('layout/footer.php'); // Include the 'footer.php' file, which contains the HTML footer section of the website.
?>