<?php
session_start();
// Include necessary PHP files
include('layouts/header.php'); // Include the 'header.php' file, which contains the HTML header section of the website.
include('layouts/sidebar.php'); // Include the 'sidebar.php' file, which contains the website's navigation menu.
include('dbconnect.php'); // Include the 'dbconnect.php' file to establish a database connection.
try {
    // Prepare and execute a database query to select all records from the 'packages' table
    $stmt = $pdo->prepare('SELECT * FROM packages');
    $stmt->execute();
    $packages = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as an associative array.
} catch (PDOException $e) {
    die("Error: " . $e->getMessage()); // Handle any database connection errors.
}

?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Data Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Data</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <!-- Alert message once package is been updated, added and deleted -->
                <?php if (isset($_SESSION['message'])) {
                    echo ' <h5 class="alert alert-success">' . $_SESSION['message'] . '</h5>';
                    unset($_SESSION['message']); // Clear the session message
                } ?>
                <div class="card">
                    <!-- This will crate table to display package information -->
                    <div class="card-body">
                        <h5 class="card-title">Datatables</h5>
                        <p>Add Package Information. The added information are shown below.</p>
                        <a href="addPackages.php"><button type="button" class="btn btn-success">Add</button></a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Image</th>
                                    <th scope="col">Package Name</th>
                                    <th scope="col">No. Of Days</th>
                                    <th scope="col">Difficulty</th>
                                    <th scope="col">Package Cost</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($packages as $package) {
                                    echo '<tr>';
                                    // Fetches package image from table 
                                    echo '<td><img style="width: 100px;" src="assets/img/package/' . $package['packageImg'] . '" /></a></td>';
                                    // Fetches package name from table
                                    echo '<td>' . $package['packageName'] . '</td>';
                                    // Fetches no of days from table
                                    echo '<td>' . $package['noOfDays'] . '</td>';
                                    // Fetches package difficulty from table
                                    echo '<td>' . $package['packageDifficulty'] . '</td>';
                                    // Fetches package cost from table
                                    echo '<td>$' . $package['packageCost'] . '</td>';

                                    echo '<td>';
                                    // buttons for edit and delete package, it redirects to respective page and information is loade using id
                                    echo '<a href="editPackages.php?id=' . $package['packageId'] . '" class="btn btn-primary">Edit</a>';
                                    echo '<form method="post" action="deletePackages.php" style="display: inline;">
                                        <input type="hidden" name="id" value="' . $package['packageId'] . '" />
                                        <button type="submit" name="delete_package" value="<?=$row->packageId;?>" class="btn btn-danger">Delete</button>
                                    </form>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
include('layouts/footer.php'); // Include the 'footer.php' file, which contains the HTML footer section of the website.
?>
<script>
    // Automatically hide the alert message after 3 seconds
    setTimeout(function() {
        document.querySelector('.alert').style.display = 'none';
    }, 3000);
</script>