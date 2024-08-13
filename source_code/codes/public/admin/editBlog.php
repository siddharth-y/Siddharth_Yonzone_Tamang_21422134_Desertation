<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');

// Initialize $alertMessage variable
$alertMessage = '';

if (isset($_POST['update_blog_btn'])) {
    $blogId = $_POST['blogId'];
    $blogName = $_POST['blogName'];
    $blogTitle = $_POST['blogTitle'];
    $blogDescription = $_POST['blogDescription'];
    $blogImg = $_FILES['blogImg']['name'];

    // Prepare the update statement
    $stmt = $pdo->prepare('UPDATE blogs 
                           SET blogName = :blogName, 
                               blogTitle = :blogTitle, 
                               blogDescription = :blogDescription, 
                               blogImg = :blogImg 
                           WHERE blogId = :blogId');

    // Bind parameters
    $stmt->bindParam(':blogId', $blogId);
    $stmt->bindParam(':blogName', $blogName);
    $stmt->bindParam(':blogTitle', $blogTitle);
    $stmt->bindParam(':blogDescription', $blogDescription);
    $stmt->bindParam(':blogImg', $blogImg);

    // Execute the update query
    $queryResult = $stmt->execute();

    if ($queryResult) {
        $_SESSION['message'] = 'Blog Successfully Edited!';
        // Redirect to packages.php using JavaScript
        echo '<script>window.location.href = "blogs.php";</script>';
    } else {
        $_SESSION['message'] = 'Error Editing Blog!';
    }

    if ($_FILES['vehicleImg']['error'] == 0) {
        // Creating the image file name
        $fileName = $vehicleId . '.jpg';
        // Moving the uploaded image to the specified directory
        move_uploaded_file($_FILES['vehicleImg']['tmp_name'], '../assets/img/' . $fileName);
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
        <h1>Edit Blog</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="blogs.php">Blog</a></li>
                <li class="breadcrumb-item active"><a href="editBlogs.php">Edit Blog</a></li>
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
                            $blogId = $_GET['id'];

                            $query = "SELECT * FROM blogs WHERE blogId= :blogId LIMIT 1";
                            $stmt = $pdo->prepare($query);
                            $data = [
                                ':blogId' => $blogId
                            ];
                            $stmt->execute($data);

                            // Fetch the package data
                            $result = $stmt->fetch(PDO::FETCH_OBJ);
                        }
                        ?>
                        <h5 class="card-title">Edit Blog</h5>
                        <p>Edit an existing Blog with the form below.</p>

                        <form action="editBlog.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="blogId" value="<?= $result->blogId ?>" />
                            <div class="mb-3">
                                <label for="blogName" class="form-label">Blog Name</label>
                                <input type="text" name="blogName" class="form-control" value="<?= $result->blogName; ?>" />
                            </div>

                            <div class="mb-3">
                                <label for="blogTitle" class="form-label">Vehicle Title</label>
                                <input type="text" name="blogTitle" class="form-control" value="<?= $result->blogTitle; ?>" />
                            </div>

                            <div class="mb-3">
                                <label for="blogImg" class="form-label">Upload Photo</label>
                                <input class="form-control" name="blogImg" type="file" id="blogImg" value="<?= $result->blogImg; ?>" />
                            </div>

                            <section class="section">

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Blog Description</h5>
                                        <!-- TinyMCE Editor -->
                                        <textarea class="tinymce-editor" name="blogDescription" id="blogDescription" rows="5" class="form-control"><?= $result->blogDescription; ?></textarea>
                                        <!-- End TinyMCE Editor -->

                                    </div>
                                </div>

                            </section>

                            <div class="row mb-3">
                                <!-- <label class="col-sm-2 col-form-label">Submit Button</label> -->
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary" name="update_blog_btn">Update
                                        Blog
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