<?php
// Include necessary PHP files
include('layout/header.php'); // Include the 'header.php' file, which contains the HTML header section of the website.
include('layout/navigation.php'); // Include the 'navigation.php' file, which contains the website's navigation menu.
include('admin/dbconnect.php'); // Include the 'dbconnect.php' file to establish a database connection.
try {
    // Prepare and execute a database query to select all records from the 'transportations' table
    $stmt = $pdo->prepare('SELECT * FROM transportations');
    $stmt->execute();
    $transportations = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as an associative array.
} catch (PDOException $e) {
    die("Error: " . $e->getMessage()); // Handle any database connection errors.
}
?>

<main id="main" class="scrolled-offset">
    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="index.php">Home</a></li>
                <li>Accommodation</li>
            </ol>
            <h2>Accommodation</h2>
        </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
        <div class="container">
            <?php
            $rowCount = 0; // Initialize row count
            foreach ($transportations as $transportation) :
                if ($rowCount % 3 == 0) :
                    if ($rowCount > 0) {
                        echo '</div>'; // Close the previous row if not the first
                    }
                    echo '<div class="row">';
                endif;
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <!-- Get transportation id -->
                        <a href="transportationDetail.php?id=<?php echo $transportation['vehicleId']; ?>"> <!-- Wrap the entire card with the anchor tag -->
                            <!-- Get vehicle image from transportation -->
                            <?php echo '<img class="card-img-top" src="admin/assets/img/transpo/' . $transportation['vehicleImg'] . '" alt="Vehicle image">'; ?>
                            <div class="card-body">
                                <!-- Get vehical name form array -->
                                <h5 class="card-title"><?php echo $transportation['vehicleName']; ?></h5>
                                <!-- Get vechicle description -->
                                <p class="card-text package-description"><?php echo shortenText($transportation['vehicleDescription'], 50); ?></p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                        </a>
                    </div>
                </div>
            <?php
                if ($rowCount % 3 == 2 || $rowCount == count($transportation) - 1) :
                    echo '</div>'; // Close the row after every three 
                endif;
                $rowCount++;
            endforeach;
            ?>
        </div>
    </section>

</main><!-- End #main -->

<style>
    /* Add hover effect to the card */
    .card:hover {
        transform: scale(1.05);
        /* Increase the size of the card on hover */
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        /* Add a subtle box shadow */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        /* Add smooth transition effects */
    }

    /* Style for limiting text to one line with ellipsis */
    .package-description {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<?php
include('layout/footer.php'); // Include the 'footer.php' file, which contains the HTML footer section of the website.
?>