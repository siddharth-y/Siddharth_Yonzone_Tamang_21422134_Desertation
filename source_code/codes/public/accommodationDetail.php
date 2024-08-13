<?php
// Include necessary PHP files
include('layout/header.php'); // Include the 'header.php' file, which contains the HTML header section of the website.
include('layout/navigation.php'); // Include the 'navigation.php' file, which contains the website's navigation menu.
include('admin/dbconnect.php'); // Include the 'dbconnect.php' file to establish a database connection.


// Check if 'id' is set and is a valid number
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch hotel records related to the trekking package using packageId
    $stmt = $pdo->prepare('SELECT * FROM hotels WHERE hotelId = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $hotel = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single row

    if (!empty($hotel)) { // Check if data exists
        // Display the hotel details
?>
        <main id="main" class="scrolled-offset">
            <!-- ======= Breadcrumbs ======= -->
            <section id="breadcrumbs" class="breadcrumbs">
                <div class="container">
                    <ol>
                        <li><a href="index.php">Home</a></li>
                        <li>Accommodation Details</li>
                    </ol>
                    <h2><?php echo $hotel['hotelName']; ?></h2>
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
                                            <?php echo '<img class="card-img-top" src="admin/assets/img/acco/' . $hotel['hotelImg'] . '" alt="hotel image">'; ?>
                                        </div>
                                        <!-- Add more images here if needed -->
                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                                <!-- Fetches hotel name according to hotel id -->
                                <h3><?php echo $hotel['hotelName']; ?></h3>
                                <ul>
                                    <!-- fetch hotel type -->
                                    <li><strong>Hotel Type</strong>: <?php echo $hotel['hotelType']; ?></li>
                                    <!-- fetch hotel address -->
                                    <li><strong>Address</strong>: <?php echo $hotel['address']; ?></li>
                                    <!-- fetch hotel cost -->
                                    <li><strong>Price</strong>: $<?php echo $hotel['hotelCost']; ?></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="portfolio-description">
                                <h2>Hotel Detail</h2>
                                <p>
                                    <!-- fetch hotel description -->
                                    <?php echo $hotel['hotelDescription']; ?>
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
    } else {
        echo "<p>Hotel not found.</p>";
    }
} else {
    echo "<p>Invalid or missing hotel ID.</p>";
}

include('layout/footer.php');
?>