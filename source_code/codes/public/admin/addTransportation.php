<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Initialize $aleartMessage variable
$aleartMessage = '';

if (isset($_POST['save_transpo_btn'])) {
  // Insert query

  $stmt = $pdo->prepare('INSERT INTO transportations (vehicleName, vehicleDescription, vehicleType, noOfSeat, vehicleImg, vehicleCost)
  VALUES (:vehicleName, :vehicleDescription, :vehicleType, :noOfSeat, :vehicleImg, :vehicleCost)');

  $criteria = [
    ':vehicleName' => $_POST['vehicleName'],
    ':vehicleDescription' => $_POST['vehicleDescription'],
    ':vehicleType' => $_POST['vehicleType'],
    ':noOfSeat' => $_POST['noOfSeat'],
    ':vehicleImg' => $_FILES['vehicleImg']['name'],
    ':vehicleCost' => $_POST['vehicleCost'],
  ];

  $queryResult = $stmt->execute($criteria);

  if ($queryResult) {
    $_SESSION['message'] = 'Vehicle Successfully Added!';
    // Redirect to packages.php using JavaScript
    echo '<script>window.location.href = "transportation.php";</script>';
  } else {
    $_SESSION['message'] = 'Error Adding Vehicle!';
  }

  if ($_FILES['vehicleImg']['error'] == 0) {
    // Creating the image file name
    $fileName = $pdo->lastInsertId() . '.jpg' . '.jpeg' . '.png';
    // Moving the uploaded image to the specified directory
    move_uploaded_file($_FILES['vehicleImg']['tmp_name'], '../assets/img/transpo/' . $fileName);
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
    <h1>Add Vehicle</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="transportation.php">Transportation</a></li>
        <li class="breadcrumb-item active"><a href="addTransportation.php">Add Vehicle</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Add Vehicle</h5>
            <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable</p>

            <!-- Table with stripped rows -->
            <form action="addTransportation.php" method="POST" enctype="multipart/form-data">
              <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Vehicle Name</label>
                <div class="col-sm-10">
                  <input type="text" name="vehicleName" class="form-control" />
                </div>
              </div>
              <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Vehicle Type</label>
                <div class="col-sm-10">
                  <input type="text" name="vehicleType" class="form-control" />
                </div>
              </div>
              <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">No of Seat</label>
                <div class="col-sm-10">
                  <input type="text" name="noOfSeat" class="form-control" />
                </div>
              </div>
              <div class="row mb-3">
                <label for="inputNumber" class="col-sm-2 col-form-label">Upload Photo</label>
                <div class="col-sm-10">
                  <input class="form-control" name="vehicleImg" type="file" id="formFile" />
                </div>
              </div>

              <section class="section">

                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">TinyMCE Editor</h5>

                    <!-- TinyMCE Editor -->
                    <textarea class="tinymce-editor" name="vehicleDescription" id="vehicleDescription" rows="5" class="form-control">
              </textarea><!-- End TinyMCE Editor -->

                  </div>
                </div>

              </section>
              <div class="input-group mb-3">
                <span class="input-group-text">$</span>
                <input type="text" class="form-control" name="vehicleCost" aria-label="Amount (to the nearest dollar)" />
                <span class="input-group-text">.00</span>
              </div>
              <div class="row mb-3">
                <!-- <label class="col-sm-2 col-form-label">Submit Button</label> -->
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary" name="save_transpo_btn">Post</button>
                </div>
              </div>

            </form>
            <script>
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
include('layouts/footer.php')
?>