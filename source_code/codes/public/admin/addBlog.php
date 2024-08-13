<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Initialize $aleartMessage variable
$aleartMessage = '';

if (isset($_POST['save_blog_btn'])) {
  // Insert query
  $stmt = $pdo->prepare('INSERT INTO blogs (blogName, blogDescription, blogTitle, blogImg )
                         VALUES (:blogName, :blogDescription, :blogTitle, :blogImg)');

  $criteria = [
    ':blogName' => $_POST['blogName'],
    ':blogDescription' => $_POST['blogDescription'],
    ':blogTitle' => $_POST['blogTitle'],
    ':blogImg' => $_FILES['blogImg']['name'],

  ];

  $queryResult = $stmt->execute($criteria);

  if ($queryResult) {
    $_SESSION['message'] = 'Blog Successfully Added!';
    // Redirect to packages.php using JavaScript
    echo '<script>window.location.href = "blogs.php";</script>';
  } else {
    $_SESSION['message'] = 'Error Adding Blog!';
  }

  if ($_FILES['vehicleImg']['error'] == 0) {
    // Creating the image file name
    $fileName = $pdo->lastInsertId() . '.jpg' . '.png' . 'jpeg';
    // Moving the uploaded image to the specified directory
    move_uploaded_file($_FILES['vehicleImg']['tmp_name'], 'assets/img/blog/' . $fileName);
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
    <h1>Add Blog</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="blogs.php">Blog</a></li>
        <li class="breadcrumb-item active"><a href="blogs.php">Add blog</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Add Blog</h5>
            <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable</p>

            <!-- Table with stripped rows -->
            <form action="addBlog.php" method="POST" enctype="multipart/form-data">
              <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Blog Name</label>
                <div class="col-sm-10">
                  <input type="text" name="blogName" class="form-control" />
                </div>
              </div>
              <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Blog Title</label>
                <div class="col-sm-10">
                  <input type="text" name="blogTitle" class="form-control" />
                </div>
              </div>
              <div class="row mb-3">
                <label for="inputNumber" class="col-sm-2 col-form-label">Upload Photo</label>
                <div class="col-sm-10">
                  <input class="form-control" name="blogImg" type="file" id="formFile" />
                </div>
              </div>

              <section class="section">

                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">TinyMCE Editor</h5>

                    <!-- TinyMCE Editor -->
                    <textarea class="tinymce-editor" name="blogDescription" id="blogDescription" rows="5" class="form-control">
              </textarea><!-- End TinyMCE Editor -->

                  </div>
                </div>

              </section>

              <div class="row mb-3">
                <!-- <label class="col-sm-2 col-form-label">Submit Button</label> -->
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary" name="save_blog_btn">Post</button>
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