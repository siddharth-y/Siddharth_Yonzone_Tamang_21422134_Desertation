<?php
// Include necessary PHP files
include('layout/header.php'); // Include the 'header.php' file, which contains the HTML header section of the website.
include('layout/navigation.php'); // Include the 'navigation.php' file, which contains the website's navigation menu.
include('admin/dbconnect.php'); // Include the 'dbconnect.php' file to establish a database connection.

try {
  // Prepare and execute a database query to select all records from the 'packages' table
  $stmt = $pdo->prepare('SELECT * FROM packages');
  $stmt = $pdo->prepare('SELECT * FROM packages');
  $stmt->execute();
  $packages = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as an associative array.
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
        <li>Treks</li>
      </ol>
      <h2>Treks</h2>
    </div>
  </section><!-- End Breadcrumbs -->

  <!-- ======= Portfolio Section ======= -->
  <section id="portfolio" class="portfolio">
    <div class="container">
      <?php
      // This code shows 3 package cards in a row. 
      // Also package information called from above are put in cards to call the require information
      $rowCount = 0; // Initialize row count
      foreach ($packages as $package) :
        if ($rowCount % 3 == 0) :
          if ($rowCount > 0) {
            echo '</div>'; // Close the previous row if not the first
          }
          echo '<div class="row">';
        endif;
      ?>
        <div class="col-md-4 mb-4">
          <div class="card">
            <!-- This make seperate packages by calling its ids. -->
            <a href="trekkingDetail.php?id=<?php echo $package['packageId']; ?>"> <!-- Wrap the entire card with the anchor tag -->
              <!-- package image stored in database is called -->
              <?php echo '<img class="card-img-top" src="admin/assets/img/package/' . $package['packageImg'] . '" alt="Package image">'; ?>
              <div class="card-body">
                <!-- this i to call package  -->
                <h5 class="card-title"><?php echo $package['packageName']; ?></h5>
                <!-- This calls package description in brief -->
                <p class="card-text package-description"><?php echo shortenText($package['packageDescription'], 50); ?></p>
                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
              </div>
            </a>
          </div>
        </div>
      <?php
        if ($rowCount % 3 == 2 || $rowCount == count($packages) - 1) :
          echo '</div>'; // Close the row after every three packages
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
include('layout/footer.php');
?>

<?php
// Function to shorten text and add "..." if it exceeds a specified length
function shortenText($text, $maxLength)
{
  if (strlen($text) > $maxLength) {
    return substr($text, 0, $maxLength) . "...";
  } else {
    return $text;
  }
}
?>