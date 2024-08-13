<?php
session_start();
ob_start(); // Start output buffering
// Include necessary PHP files
include('layouts/header.php'); // Include the 'header.php' file, which contains the HTML header section of the website.
include('layouts/sidebar.php'); // Include the 'sidebar.php' file, which likely contains the website's navigation menu.
include('dbconnect.php'); // Include the 'dbconnect.php' file to establish a database connection.


// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  // If not logged in, redirect to the admin login page
  header('Location: login.php'); // Change 'admin_login.php' to your actual admin login page
  exit();
}
ob_end_flush(); // Flush the output buffer

// Fetch both bookings and their associated package names
$bookings = $pdo->query('SELECT bookings.*, packages.packageName FROM bookings
                        LEFT JOIN packages ON bookings.packageId = packages.packageId');

// Calculate the total number of bookings
$totalBookings = $pdo->query('SELECT COUNT(*) FROM bookings')->fetchColumn();

// Calculate the total revenue
$totalRevenue = $pdo->query('SELECT SUM(totalCost) FROM bookings')->fetchColumn();
// Calculate the total number of customers
$totalCustomers = $pdo->query('SELECT COUNT(DISTINCT customerEmail) FROM bookings')->fetchColumn();
// Calculate the total number of booking
$confirmBookingCount = $pdo->query('SELECT COUNT(DISTINCT status) FROM bookings')->fetchColumn();
?>

<body>

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <!-- Customer Booking Card -->
        <div class="col-md-6 col-xxl-3">
          <div class="card info-card sales-card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>
            <div class="card-body">
              <h5 class="card-title">Customer Booking</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-calendar-check"></i>
                </div>
                <!-- Get booking number -->
                <div class="ps-3">
                  <h6><?php echo $totalBookings; ?></h6>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Customer Booking Card -->

        <!-- Confirm Booking Card -->
        <div class="col-md-6 col-xxl-3">
          <div class="card info-card revenue-card">
            <div class="filter">
              <a class icon href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>
            <div class="card-body">
              <h5 class="card-title">Confirm Booking</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-check-circle"></i>
                </div>
                <div class="ps-3">
                  <h6 id="confirmBookingCount"><?php echo $totalBookings; ?></h6>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Confirm Booking Card -->

        <!-- Revenue Card -->
        <div class="col-md-6 col-xxl-3">
          <div class="card info-card revenue-card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>
            <div class="card-body">
              <h5 class="card-title">Revenue <span>| This Month</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="ps-3">
                  <!-- Calculate the total revenue -->
                  <h6>$<?php echo number_format($totalRevenue); ?></h6>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Revenue Card -->

        <!-- Customers Card -->
        <div class="col-md-6 col-xxl-3">
          <div class="card info-card customers-card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>
            <div class="card-body">
              <h5 class="card-title">Customers <span>| This Year</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <!-- Calculate the total number of customers -->
                  <h6><?php echo $totalCustomers; ?></h6>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Customers Card -->

        <!-- Recent Sales -->
        <div class="col-12">
          <div class="card recent-sales overflow-auto">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>
            <div class="card-body">
              <h5 class="card-title">Bookings <span>| Lists</span></h5>
              <table class="table table-borderless datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Package</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $counter = 1; // Initialize a counter for serial numbers
                  foreach ($bookings as $booking) {
                    echo '<tr>';
                    echo '<th scope="row">' . $counter . '</th>';
                    echo '<td>' . $booking['customerName'] . '</td>';
                    echo '<td><a href="#" class="text-primary">' . (isset($booking['packageName']) ? $booking['packageName'] : 'N/A') . '</a></td>';
                    echo '<td>';

                    if (isset($booking['status'])) {
                      if ($booking['status'] === 'Approved') {
                        echo '<span class="badge bg-success">' . $booking['status'] . '</span>';
                      } else {
                        echo '<span class="badge bg-warning">Pending</span>';
                      }
                    } else {
                      echo '<span class="badge bg-warning">Pending</span>';
                    }

                    echo '</td>';
                    echo '</tr>';
                    $counter++; // Increment the counter for the next row
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div><!-- End Recent Sales -->
      </div><!-- End row -->
    </section>
  </main><!-- End #main -->
  <?php include('layouts/footer.php'); ?>
</body>

</html>

<!-- Add this script at the end of your 'index.php' file, before the closing </body> tag -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    // Function to update the Confirm Booking meter
    function updateConfirmBookingMeter() {
      // Send an AJAX request to approve the booking and get the updated count
      $.ajax({
        type: "GET",
        url: "confirmBooking.php?id=" + bookingId, // Pass the booking ID to confirmBooking.php
        success: function(response) {
          // Parse the JSON response
          var data = JSON.parse(response);

          // Display the success message
          alert(data.message);

          // Update the Confirm Booking meter with the new count
          $("#confirmBookingCount").text(data.confirmBookingCount);
        },
        error: function() {
          // Handle errors, if any
          alert("Error approving booking.");
        }
      });
    }

    // Event handler for approving a booking
    $(".approve-booking").on("click", function() {
      var bookingId = $(this).data("booking-id");

      // Call the function to update the Confirm Booking meter
      updateConfirmBookingMeter();
    });

    // Initial update of the Confirm Booking meter
    updateConfirmBookingMeter();
  });
</script>