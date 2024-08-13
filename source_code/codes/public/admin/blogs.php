<?php
session_start();
include('layouts/header.php');
include('layouts/sidebar.php');
include('dbconnect.php');
$blogs = $pdo->query('SELECT * FROM blogs ');
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Blog Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Blog</li>
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
                        <h5 class="card-title">Blog Table</h5>
                        <p>Add, edit, delete blogs</p>
                        <a href="addBlog.php"><button type="button" class="btn btn-success">Add</button></a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Blog Image</th>
                                    <th scope="col">Blog Name</th>
                                    <th scope="col">Description</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($blogs as $blog) {
                                    echo '<td><img src="assets/img/blog/' . $blog['blogImg'] . '" /></a></td>';
                                    echo '<td>' . $blog['blogName'] . '</td>';
                                    echo '<td>' . $blog['blogDescription'] . '</td>';
                                    echo '<td>';
                                    echo '<a href="editBlog.php?id=' . $blog['blogId'] . '" class="btn btn-primary">Edit</a>';
                                    echo '<form method="post" action="deleteBlog.php" style="display: inline;">
                                        <input type="hidden" name="id" value="' . $blog['blogId'] . '" />
                                        <button type="submit" name="delete_blog" value="<?=$row->blogId;?>" class="btn btn-danger">Delete</button>
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
include('layouts/footer.php')
?>
<script>
    // Automatically hide the alert message after 3 seconds
    setTimeout(function() {
        document.querySelector('.alert').style.display = 'none';
    }, 3000);
</script>