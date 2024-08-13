<?php
session_start(); // Start a new session
// Include necessary PHP files
include('layouts/header.php'); // Include the 'header.php' file, which contains the HTML header section of the website.
include('layouts/sidebar.php'); // Include the 'sidebar.php' file, which contains the website's navigation menu.
include('dbconnect.php'); // Include the 'dbconnect.php' file to establish a database connection.

// Initialize $aleartMessage variable
$aleartMessage = '';

if (isset($_POST['save_accom_btn'])) {
  // Insert query
  // Prepare and execute a database query to select all records from the 'hotels' table
  $stmt = $pdo->prepare('INSERT INTO hotels (hotelName, address, hotelDescription, hotelType, hotelImg, hotelCost)
                         VALUES (:hotelName, :address, :hotelDescription, :hotelType, :hotelImg, :hotelCost)');

  $criteria = [
    ':hotelName' => $_POST['hotelName'],
    ':address' => $_POST['address'],
    ':hotelDescription' => $_POST['hotelDescription'],
    ':hotelType' => $_POST['hotelType'],
    ':hotelImg' => $_FILES['hotelImg']['name'],
    ':hotelCost' => $_POST['hotelCost'],
  ];

  $queryResult = $stmt->execute($criteria);

  if ($queryResult) {
    $_SESSION['message'] = 'Hotel Successfully Added!';
    // Redirect to packages.php using JavaScript
    echo '<script>window.location.href = "accommodation.php";</script>';
  } else {
    $_SESSION['message'] = 'Error Adding Hotel!';
  }

  if ($_FILES['hotelImg']['error'] == 0) {
    // Creating the image file name
    $fileName = $pdo->lastInsertId() . '.jpg' . '.jpeg' . '.png';
    // Moving the uploaded image to the specified directory
    move_uploaded_file($_FILES['hotelImg']['tmp_name'], '../assets/img/acco/' . $fileName);
  }
}

?>
<!-- The rest of your HTML content goes here -->

<main id="main" class="main">

  <?php echo $aleartMessage; ?>
  <!-- JavaScript to automatically close the alert after a delay -->
  <script>
    // Function to close the alert after a delay
    function closeAlert() {
      var alert = document.querySelector('.alert');
      if (alert) {
        alert.style.display = 'none';
      }
    }

    // Automatically close the alert after 3 seconds
    setTimeout(closeAlert, 3000);
  </script>
  <div class="pagetitle">
    <h1>Add Hotel</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="accommodation.php">accommodation</a></li>
        <li class="breadcrumb-item active"><a href="addAccomondation.php">Add Hotel</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Add Hotel</h5>

            <!-- Table with stripped rows -->
            <form action="addAccommodation.php" method="POST" enctype="multipart/form-data">
              <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Hotel Name</label>
                <div class="col-sm-10">
                  <input type="text" name="hotelName" class="form-control" />
                </div>
              </div>
              <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                  <input type="text" name="address" class="form-control" />
                </div>
              </div>
              <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Hotel Type</label>
                <div class="col-sm-10">
                  <input type="text" name="hotelType" class="form-control" />
                </div>
              </div>
              <div class="row mb-3">
                <label for="inputNumber" class="col-sm-2 col-form-label">Upload Photo</label>
                <div class="col-sm-10">
                  <input class="form-control" name="hotelImg" type="file" id="formFile" />
                </div>
              </div>

              <section class="section">

                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Add Description</h5>

                    <!-- TinyMCE Editor -->
                    <textarea class="tinymce-editor" name="hotelDescription" id="hotelDescription" rows="5" class="form-control">
              </textarea><!-- End TinyMCE Editor -->

                  </div>
                </div>

              </section>
              <div class="input-group mb-3">
                <span class="input-group-text">$</span>
                <input type="text" class="form-control" name="hotelCost" aria-label="Amount (to the nearest dollar)" />
                <span class="input-group-text">.00</span>
              </div>
              <div class="row mb-3">
                <!-- <label class="col-sm-2 col-form-label">Submit Button</label> -->
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary" name="save_accom_btn">Post</button>
                </div>
              </div>

            </form>
            <script>
              //  TinyMCE Editor
              tinymce.init({
                selector: "textarea#packageDescription",
                plugins: [
                  "advlist autolink lists link image charmap print preview anchor",
                  "searchreplace visualblocks code fullscreen",
                  "insertdatetime media table paste",
                ],
                toolbar: "bold italic | fontsizeselect fontselect",
                fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
                font_formats: "Arial=arial,helvetica,sans-serif;Comic Sans MS=comic sans ms,sans-serif;Times New Roman=times new roman,times,serif",
              });
            </script>

          </div>
        </div>
      </div>
  </section>
</main>
<?php
include('layouts/footer.php'); // Include the 'footer.php' file, which contains the HTML footer section of the website.
?>