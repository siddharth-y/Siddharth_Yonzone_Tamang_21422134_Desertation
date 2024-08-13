<?php
session_start(); // Start a new session
// Include necessary PHP files
include('layouts/header.php'); // Include the 'header.php' file, which contains the HTML header section of the website.
include('layouts/sidebar.php'); // Include the 'sidebar.php' file, which contains the website's navigation menu.
include('dbconnect.php'); // Include the 'dbconnect.php' file to establish a database connection.

// Initialize $alertMessage variable
$alertMessage = '';

if (isset($_POST['save_package_btn'])) {
  // Prepare and execute a database query to select all records from the 'packages' table
  // Insert query
  $stmt = $pdo->prepare('INSERT INTO packages (packageName, packageTitle, packageDescription, packageCost, packageImg, packageDifficulty, noOfDays)
                            VALUES (:packageName, :packageTitle, :packageDescription, :packageCost, :packageImg, :packageDifficulty, :noOfDays)');

  $criteria = [
    ':packageName' => $_POST['packageName'],
    ':packageTitle' => $_POST['packageTitle'],
    ':packageDescription' => $_POST['packageDescription'],
    ':packageCost' => $_POST['packageCost'],
    ':packageImg' => $_FILES['packageImg']['name'],
    ':packageDifficulty' => $_POST['packageDifficulty'],
    ':noOfDays' => $_POST['noOfDays'],
  ];

  $queryResult = $stmt->execute($criteria);

  if ($queryResult) {
    $_SESSION['message'] = 'Package Successfully Added!';
    // Redirect to packages.php using JavaScript
    echo '<script>window.location.href = "packages.php";</script>';
  } else {
    $_SESSION['message'] = 'Error Adding Package!';
  }

  if ($_FILES['packageImg']['error'] == 0) {
    // Creating the image file name
    $fileName = $pdo->lastInsertId() . '.jpg' . '.png' . 'jpeg';
    // Moving the uploaded image to the specified directory
    move_uploaded_file($_FILES['packageImg']['tmp_name'], 'admin/assets/img/package/' . $fileName);
  }
}
?>
<!-- The rest of your HTML content goes here -->

<main id="main" class="main">

  <?php echo $alertMessage; ?>
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
    <h1>Data Tables</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="package.php">Package</a></li>
        <li class="breadcrumb-item active"><a href="addPackage.php">Add Package</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Add Package</h5>
            <p>Add, edit and delete package</p>

            <!-- Table with stripped rows -->
            <form action="addPackages.php" method="POST" enctype="multipart/form-data">
              <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Package Name</label>
                <div class="col-sm-10">
                  <input type="text" name="packageName" class="form-control" />
                </div>
              </div>
              <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Package Title</label>
                <div class="col-sm-10">
                  <input type="text" name="packageTitle" class="form-control" />
                </div>
              </div>
              <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">No. Of Days</label>
                <div class="col-sm-10">
                  <input type="text" name="noOfDays" class="form-control" />
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Select Difficulty</label>
                <div class="col-sm-10">
                  <select class="form-select" name="packageDifficulty" aria-label="Default select example">
                    <option selected>Easy</option>
                    <option value="Easy">Easy</option>
                    <option value="Normal">Normal</option>
                    <option value="Hard">Hard</option>
                  </select>
                </div>
              </div>
              <div class="row mb-3">
                <label for="inputNumber" class="col-sm-2 col-form-label">Upload Photo</label>
                <div class="col-sm-10">
                  <input class="form-control" name="packageImg" type="file" id="formFile" />
                </div>
              </div>

              <section class="section">

                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Package Description</h5>

                    <!-- TinyMCE Editor -->
                    <textarea class="tinymce-editor" name="packageDescription" id="packageDescription" rows="5" class="form-control">
              </textarea><!-- End TinyMCE Editor -->

                  </div>
                </div>

              </section>
              <div class="input-group mb-3">
                <span class="input-group-text">$</span>
                <input type="text" class="form-control" name="packageCost" aria-label="Amount (to the nearest dollar)" />
                <span class="input-group-text">.00</span>
              </div>
              <div class="row mb-3">
                <!-- <label class="col-sm-2 col-form-label">Submit Button</label> -->
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary" name="save_package_btn">Post</button>
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