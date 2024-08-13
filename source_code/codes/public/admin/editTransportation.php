<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Initialize $alertMessage variable
$alertMessage = '';

if (isset($_POST['update_transpo_btn'])) {
    $vehicleId = $_POST['vehicleId'];
    $vehicleName = $_POST['vehicleName'];
    $vehicleType = $_POST['vehicleType'];
    $vehicleDescription = $_POST['vehicleDescription'];
    $vehicleCost = $_POST['vehicleCost'];
    $vehicleImg = $_FILES['vehicleImg']['name'];

    // Prepare the update statement
    $stmt = $pdo->prepare('UPDATE transportations 
                           SET vehicleName = :vehicleName, 
                               vehicleType = :vehicleType, 
                               vehicleDescription = :vehicleDescription, 
                               vehicleCost = :vehicleCost, 
                               vehicleImg = :vehicleImg 
                           WHERE vehicleId = :vehicleId');

    // Bind parameters
    $stmt->bindParam(':vehicleId', $vehicleId);
    $stmt->bindParam(':vehicleName', $vehicleName);
    $stmt->bindParam(':vehicleType', $vehicleType);
    $stmt->bindParam(':vehicleDescription', $vehicleDescription);
    $stmt->bindParam(':vehicleCost', $vehicleCost);
    $stmt->bindParam(':vehicleImg', $vehicleImg);

    // Execute the update query
    $queryResult = $stmt->execute();

    if ($queryResult) {
        $_SESSION['message'] = 'Vehicle Successfully Edited!';
        // Redirect to packages.php using JavaScript
        echo '<script>window.location.href = "transportation.php";</script>';
    } else {
        $_SESSION['message'] = 'Error Editing Vehicle!';
    }

    if ($_FILES['vehicleImg']['error'] == 0) {
        // Creating the image file name
        $fileName = $vehicleId . '.jpg' . '.jpeg' . '.png';
        // Moving the uploaded image to the specified directory
        move_uploaded_file($_FILES['vehicleImg']['tmp_name'], '../assets/img/transpo/' . $fileName);
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
        <h1>Edit Vehicle</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="transportation.php">Transportation</a></li>
                <li class="breadcrumb-item active">Edit Transportation</li>
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
                            $vehicleId = $_GET['id'];

                            $query = "SELECT * FROM transportations WHERE vehicleId= :vehicleId LIMIT 1";
                            $stmt = $pdo->prepare($query);
                            $data = [
                                ':vehicleId' => $vehicleId
                            ];
                            $stmt->execute($data);

                            // Fetch the package data
                            $result = $stmt->fetch(PDO::FETCH_OBJ);
                        }
                        ?>
                        <h5 class="card-title">Edit Vehicle</h5>
                        <p>Edit an existing vehicle with the form below.</p>

                        <form action="editTransportation.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="vehicleId" value="<?= $result->vehicleId ?>" />
                            <div class="mb-3">
                                <label for="vehicleName" class="form-label">Vehicle Name</label>
                                <input type="text" name="vehicleName" class="form-control" value="<?= $result->vehicleName; ?>" />
                            </div>

                            <div class="mb-3">
                                <label for="vehicleType" class="form-label">Vehicle Type</label>
                                <input type="text" name="vehicleType" class="form-control" value="<?= $result->vehicleType; ?>" />
                            </div>

                            <div class="mb-3">
                                <label for="vehicleImg" class="form-label">Upload Photo</label>
                                <input class="form-control" name="vehicleImg" type="file" id="vehicleImg" value="<?= $result->vehicleImg; ?>" />
                            </div>

                            <section class="section">

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">TinyMCE Editor</h5>
                                        <!-- TinyMCE Editor -->
                                        <textarea class="tinymce-editor" name="vehicleDescription" id="vehicleDescription" rows="5" class="form-control"><?= $result->vehicleDescription; ?></textarea>
                                        <!-- End TinyMCE Editor -->

                                    </div>
                                </div>

                            </section>

                            <div class="mb-3">
                                <label for="vehicleCost" class="form-label">Vehicle Cost</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control" name="vehicleCost" aria-label="Amount (to the nearest dollar)" value="<?= $result->vehicleCost; ?>" />
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- <label class="col-sm-2 col-form-label">Submit Button</label> -->
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary" name="update_transpo_btn">Update
                                        Vehicle
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
include('layouts/footer.php')
?>