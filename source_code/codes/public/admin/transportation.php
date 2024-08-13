<?php
session_start(); // Start a new session
// Include necessary PHP files
include('layouts/header.php'); // Include the 'header.php' file, which contains the HTML header section of the website.
include('layouts/sidebar.php'); // Include the 'sidebar.php' file, which contains the website's navigation menu.
include('dbconnect.php'); // Include the 'dbconnect.php' file to establish a database connection.

// Prepare and execute a database query to select all records from the 'transportations' table
$transportations = $pdo->query('SELECT * FROM transportations ');
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Transportation Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Transportation</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <?php if (isset($_SESSION['message'])) {
                    echo ' <h5 class="alert alert-success">' . $_SESSION['message'] . '</h5>';
                    unset($_SESSION['message']); // Clear the session message
                } ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Transportation Table</h5>
                        <p>Add Vehicle</p>
                        <a href="addTransportation.php"><button type="button" class="btn btn-success">Add</button></a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Vehicle Image</th>
                                    <th scope="col">Vehicle Name</th>
                                    <th scope="col">Vehicle Type</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Vehicle Cost</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($transportations as $transportation) {
                                    echo '<tr>';
                                    echo '<td><img src="assets/img/transpo/' . $transportation['vehicleImg'] . '" style="width:100px;" /></a></td>';
                                    echo '<td>' . $transportation['vehicleName'] . '</td>';
                                    echo '<td>' . $transportation['vehicleDescription'] . '</td>';
                                    echo '<td>' . $transportation['vehicleType'] . '</td>';
                                    echo '<td>$' . $transportation['vehicleCost'] . '</td>';
                                    echo '<td>';
                                    echo '<a href="editTransportation.php?id=' . $transportation['vehicleId'] . '" class="btn btn-primary">Edit</a>';
                                    echo '<form method="post" action="deleteTransportation.php" style="display: inline;">
                                        <input type="hidden" name="id" value="' . $transportation['vehicleId'] . '" />
                                        <button type="submit" name="delete_transpo" value="<?=$row->hotelId;?>" class="btn btn-danger">Delete</button>
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