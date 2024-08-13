<?php
session_start(); // Start a new session

// Include necessary PHP files
include('layouts/header.php'); // Include the 'header.php' file, which contains the HTML header section of the website.
include('layouts/sidebar.php'); // Include the 'sidebar.php' file, which contains the website's navigation menu.
include('dbconnect.php'); // Include the 'dbconnect.php' file to establish a database connection.

// Prepare and execute a database query to select all records from the 'hotels' table
$accommodations = $pdo->query('SELECT * FROM hotels ');
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Accommdation Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Accommodation</li>
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
                        <h5 class="card-title">Hotel Table</h5>
                        <p>Add, edit and delete hotel.</p>
                        <a href="addAccommodation.php"><button type="button" class="btn btn-success">Add</button></a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Hotel Image</th>
                                    <th scope="col">Hotel Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Hotel Type</th>
                                    <th scope="col">Hotel Cost</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($accommodations as $accommodation) {
                                    echo '<tr>';

                                    echo '<td><img src="assets/img/acco/' . $accommodation['hotelImg'] . '" style="width:100px;" /></a></td>';
                                    echo '<td>' . $accommodation['hotelName'] . '</td>';
                                    echo '<td>' . $accommodation['address'] . '</td>';
                                    echo '<td>' . $accommodation['hotelDescription'] . '</td>';
                                    echo '<td>' . $accommodation['hotelType'] . '</td>';
                                    echo '<td>' . $accommodation['hotelCost'] . '</td>';
                                    echo '<td>';
                                    echo '<a href="editAccommodation.php?id=' . $accommodation['hotelId'] . '" class="btn btn-primary">Edit</a>';
                                    echo '<form method="post" action="deleteAccommodation.php" style="display: inline;">
                                        <input type="hidden" name="id" value="' . $accommodation['hotelId'] . '" />
                                        <button type="submit" name="delete_accom" value="<?=$row->hotelId;?>" class="btn btn-danger">Delete</button>
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
include('layouts/footer.php');  // Include the 'footer.php' file, which contains the HTML footer section of the website.
?>
<script>
    // Automatically hide the alert message after 3 seconds
    setTimeout(function() {
        document.querySelector('.alert').style.display = 'none';
    }, 3000);
</script>