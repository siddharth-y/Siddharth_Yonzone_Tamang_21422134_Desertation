<?php
session_start(); // Start a new session
// Include necessary PHP files
include('layouts/header.php'); // Include the 'header.php' file, which contains the HTML header section of the website.
include('layouts/sidebar.php'); // Include the 'sidebar.php' file, which contains the website's navigation menu.
include('dbconnect.php'); // Include the 'dbconnect.php' file to establish a database connection.


// Initialize $alertMessage variable
$alertMessage = '';

if (isset($_POST['update_accom_btn'])) {
    $hotelId = $_POST['hotelId'];
    $hotelName = $_POST['hotelName'];
    $address = $_POST['address'];
    $hotelDescription = $_POST['hotelDescription'];
    $hotelType = $_POST['hotelType'];
    $hotelCost = $_POST['hotelCost'];
    $hotelImg = $_FILES['hotelImg']['name'];

    // update statement
    // Prepare and execute a database query to select all records from the 'hotels' table
    $stmt = $pdo->prepare('UPDATE hotels 
                           SET hotelName = :hotelName, 
                               address = :address, 
                               hotelDescription = :hotelDescription, 
                               hotelType = :hotelType,
                               hotelCost = :hotelCost, 
                               hotelImg = :hotelImg 
                           WHERE hotelId = :hotelId');

    // Bind parameters
    $stmt->bindParam(':hotelId', $hotelId);
    $stmt->bindParam(':hotelName', $hotelName);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':hotelDescription', $hotelDescription);
    $stmt->bindParam(':hotelType', $hotelType);
    $stmt->bindParam(':hotelCost', $hotelCost);
    $stmt->bindParam(':hotelImg', $hotelImg);

    // Execute the update query
    $queryResult = $stmt->execute();

    if ($queryResult) {
        $_SESSION['message'] = 'Hotel Successfully Edited!';
        // Redirect to packages.php using JavaScript
        echo '<script>window.location.href = "accommodation.php";</script>';
    } else {
        $_SESSION['message'] = 'Error Editing Hotel!';
    }

    if ($_FILES['hotelImg']['error'] == 0) {
        // Creating the image file name
        $fileName = $hotelId . '.jpg' . '.jpeg' . '.png';
        // Moving the uploaded image to the specified directory
        move_uploaded_file($_FILES['hotelImg']['tmp_name'], '../assets/img/acco/' . $fileName);
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
        <h1>Edit Hotel</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="accommodation.php">Accommdation</a></li>
                <li class="breadcrumb-item active">Edit Accommdation</li>
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
                            $hotelId = $_GET['id'];

                            $query = "SELECT * FROM hotels WHERE hotelId= :hotelId LIMIT 1";
                            $stmt = $pdo->prepare($query);
                            $data = [
                                ':hotelId' => $hotelId
                            ];
                            $stmt->execute($data);

                            // Fetch the package data
                            $result = $stmt->fetch(PDO::FETCH_OBJ);
                        }
                        ?>
                        <h5 class="card-title">Hotel Package</h5>
                        <p>Edit an existing hotel with the form below.</p>

                        <form action="editAccommodation.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="hotelId" value="<?= $result->hotelId ?>" />
                            <div class="mb-3">
                                <label for="hotelName" class="form-label">Hotel Name</label>
                                <input type="text" name="hotelName" class="form-control" value="<?= $result->hotelName; ?>" />
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" value="<?= $result->address; ?>" />
                            </div>
                            <div class="mb-3">
                                <label for="hotelType" class="form-label">Hotel Type</label>
                                <input type="text" name="hotelType" class="form-control" value="<?= $result->hotelType; ?>" />
                            </div>

                            <div class="mb-3">
                                <label for="hotelImg" class="form-label">Upload Photo</label>
                                <input class="form-control" name="hotelImg" type="file" id="hotelImg" value="<?= $result->hotelImg; ?>" />
                            </div>

                            <section class="section">

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">TinyMCE Editor</h5>
                                        <!-- TinyMCE Editor -->
                                        <textarea class="tinymce-editor" name="hotelDescription" id="hotelDescription" rows="5" class="form-control"><?= $result->hotelDescription; ?></textarea>
                                        <!-- End TinyMCE Editor -->

                                    </div>
                                </div>

                            </section>

                            <div class="mb-3">
                                <label for="hotelCost" class="form-label">Hotel Cost</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control" name="hotelCost" aria-label="Amount (to the nearest dollar)" value="<?= $result->hotelCost; ?>" />
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- <label class="col-sm-2 col-form-label">Submit Button</label> -->
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary" name="update_accom_btn">Update
                                        Hotel
                                    </button>
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
        </div>
    </section>
</main>
<?php
include('layouts/footer.php'); // Include the 'footer.php' file, which contains the HTML footer section of the website.
?>