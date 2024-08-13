<?php
// Include necessary PHP files
include_once('layout/header.php'); // Include the 'header.php' file, which contains the HTML header section of the website.
include_once('layout/navigation.php'); // Include the 'navigation.php' file, which contains the website's navigation menu.
include_once('admin/dbconnect.php'); // Include the 'dbconnect.php' file to establish a database connection.


// Check if 'id' is set and is a valid number
if (isset($_GET['id'])) {
  $id = $_GET['id'];

  // Fetch the trekking details from the database using the ID
  // Prepare and execute a database query to select all records from the 'packages' table
  $stmt = $pdo->prepare('SELECT * FROM packages WHERE packageId = :id'); // Fetch all results as an associative array.
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  $trekking = $stmt->fetch(PDO::FETCH_ASSOC); // Handle any database connection errors.

  if ($trekking) {
    // Display the trekking details
?>
    <main id="main" class="scrolled-offset">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li>Trekking Details</li>
          </ol>
          <h2><?php echo $trekking['packageName']; ?></h2>
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
                      <!-- Get package image form database -->
                      <?php echo '<img class="card-img-top" src="admin/assets/img/package/' . $trekking['packageImg'] . '" alt="Package image">'; ?>
                    </div>
                    <!-- Add more images here if needed -->
                  </div>
                  <div class="swiper-pagination"></div>
                </div>
                <!-- Get package name from table -->
                <h3><?php echo $trekking['packageName']; ?></h3>
                <ul>
                  <!-- Get no of days form package -->
                  <li><strong>No. Of Days</strong>: <?php echo $trekking['noOfDays']; ?> days</li>
                  <!-- Get package difficulty -->
                  <li><strong>Difficulty</strong>: <?php echo $trekking['packageDifficulty']; ?></li>
                  <!-- Get package cost -->
                  <li><strong>Trek Cost</strong>: $<?php echo $trekking['packageCost']; ?></li>
                </ul>
              </div>
            </div>

            <div class="col-lg-8">
              <div class="portfolio-description">
                <h2>Trekking Detail</h2>
                <p>
                  <!-- Get package description -->
                  <?php echo $trekking['packageDescription']; ?>
                </p>
              </div>
            </div>
          </div>
        </div>
      </section><!-- End Portfolio Details Section -->

      <!-- Collapsible Section for Hotel and Transportation -->
      <div id="accordion" style="margin: 15%;">
        <div class="card">
          <div class="card-header" id="headingOne">
            <h5 class="mb-0">
              <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="color: black; display:contents">
                Hotel List
              </button>
            </h5>
          </div>

          <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
              <?php
              // Include the hotel cards from hotel_card.php
              include('hotel_card.php');
              ?>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
              <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="color: black; display:contents">
                Transportation List
              </button>
            </h5>
          </div>

          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
            <div class="card-body">
              <?php
              // Include the transportation cards from transportation_card.php
              include('transportation_card.php');
              ?>
            </div>
          </div>
        </div>
        <div class="card-body" style="background: #f7f7f7; margin: 10px; margin-right: 25%; margin-left: 25%; text-align: center; border-radius: 20px; border: 1px solid #ddd;">
          <a href="booking.php?id=<?php echo $id; ?>">Book Now</a>
        </div>


        <!-- End Collapsible Section for Hotel and Transportation -->

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
    echo "<p>Trekking not found.</p>";
  }
} else {
  echo "<p>Invalid or missing trekking ID.</p>";
}

// Include the footer
include_once('layout/footer.php');
?>