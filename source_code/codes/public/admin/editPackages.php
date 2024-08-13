<?php
session_start(); // Start a new session
// Include necessary PHP files
include('layouts/header.php'); // Include the 'header.php' file, which contains the HTML header section of the website.
include('layouts/sidebar.php'); // Include the 'sidebar.php' file, which contains the website's navigation menu.
include('dbconnect.php'); // Include the 'dbconnect.php' file to establish a database connection.

// Initialize $alertMessage variable
$alertMessage = '';

if (isset($_POST['update_package_btn'])) {
    $packageId = $_POST['packageId'];
    $packageName = $_POST['packageName'];
    $packageTitle = $_POST['packageTitle'];
    $packageDescription = $_POST['packageDescription'];
    $packageCost = $_POST['packageCost'];
    $packageImg = $_FILES['packageImg']['name'];

    // Prepare and execute a database query to select all records from the 'packages' table
    // update package statement
    $stmt = $pdo->prepare('UPDATE packages 
                           SET packageName = :packageName, 
                               packageTitle = :packageTitle, 
                               packageDescription = :packageDescription, 
                               packageCost = :packageCost, 
                               packageImg = :packageImg 
                           WHERE packageId = :packageId');

    // Bind parameters
    $stmt->bindParam(':packageId', $packageId);
    $stmt->bindParam(':packageName', $packageName);
    $stmt->bindParam(':packageTitle', $packageTitle);
    $stmt->bindParam(':packageDescription', $packageDescription);
    $stmt->bindParam(':packageCost', $packageCost);
    $stmt->bindParam(':packageImg', $packageImg);

    // Execute the update query
    $queryResult = $stmt->execute();

    if ($queryResult) {
        $_SESSION['message'] = 'Package Successfully Edited!';
        // Redirect to packages.php using JavaScript
        echo '<script>window.location.href = "packages.php";</script>';
    } else {
        $_SESSION['message'] = 'Error Editing Package!';
    }

    if ($_FILES['packageImg']['error'] == 0) {
        // Creating the image file name
        $fileName = $packageId . '.jpg' . '.jpeg' . '.png';
        // Moving the uploaded image to the specified directory
        move_uploaded_file($_FILES['packageImg']['tmp_name'], '../assets/img/package/' . $fileName);
    }
}
?>

<!-- The rest of your HTML content here -->

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
    <!-- Your HTML content for the edit package form -->
    <div class="pagetitle">
        <h1>Edit Package</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="package.php">Package</a></li>
                <li class="breadcrumb-item active">Edit Package</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <?php
                        if (isset($_GET['id'])) {
                            $packageId = $_GET['id'];

                            $query = "SELECT * FROM packages WHERE packageId=:packageId LIMIT 1";
                            $stmt = $pdo->prepare($query);
                            $data = [
                                ':packageId' => $packageId
                            ];
                            $stmt->execute($data);

                            // Fetch the package data
                            $result = $stmt->fetch(PDO::FETCH_OBJ);
                        }
                        ?>
                        <h5 class="card-title">Edit Package</h5>
                        <p>Edit an existing package with the form below.</p>

                        <form action="editPackages.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="packageId" value="<?= $result->packageId ?>" />
                            <div class="mb-3">
                                <label for="packageName" class="form-label">Package Name</label>
                                <input type="text" name="packageName" class="form-control" value="<?= $result->packageName; ?>" />
                            </div>

                            <div class="mb-3">
                                <label for="packageTitle" class="form-label">Package Title</label>
                                <input type="text" name="packageTitle" class="form-control" value="<?= $result->packageTitle; ?>" />
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
                            <div class="mb-3">
                                <label for="packageImg" class="form-label">Upload Photo</label>
                                <input class="form-control" name="packageImg" type="file" id="packageImg" value="<?= $result->packageImg; ?>" />
                            </div>

                            <section class="section">

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">TinyMCE Editor</h5>
                                        <!-- TinyMCE Editor -->
                                        <textarea class="tinymce-editor" name="packageDescription" id="packageDescription" rows="5" class="form-control"><?= $result->packageDescription; ?></textarea>
                                        <!-- End TinyMCE Editor -->

                                    </div>
                                </div>

                            </section>

                            <div class="mb-3">
                                <label for="packageCost" class="form-label">Package Cost</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control" name="packageCost" aria-label="Amount (to the nearest dollar)" value="<?= $result->packageCost; ?>" />
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- <label class="col-sm-2 col-form-label">Submit Button</label> -->
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary" name="update_package_btn">Update
                                        Package
                                    </button>
                                </div>
                            </div>

                        </form>
                        <script>
                            // TinyMCE Editor
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
        </div>
    </section>
</main>
<?php
include('layouts/footer.php'); // Include the 'footer.php' file, which contains the HTML footer section of the website.
?>
?>