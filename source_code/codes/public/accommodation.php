<?php
include('layout/header.php'); // Include the 'header.php' file, which contains the HTML header section of the website.
include('layout/navigation.php'); // Include the 'navigation.php' file, which contains the website's navigation menu.
include('admin/dbconnect.php'); // Include the 'dbconnect.php' file to establish a database connection.

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
      <div class="row">
        <?php
        // Include the hotel cards from hotel_cards.php
        include('hotel_card.php');
        ?>
      </div>
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
include('layout/footer.php'); // Include the 'footer.php' file, which likely contains the HTML footer section of the website.
?>