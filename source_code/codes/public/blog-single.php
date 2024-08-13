<?php
include('layout/header.php');
include('layout/navigation.php');
include('admin/dbconnect.php'); // Include your database connection script

// Ensure that the 'id' parameter is set and is a valid integer
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $blogId = $_GET['id'];

  // Fetch the specific blog post from the database
  $sql = 'SELECT * FROM blogs WHERE blogId = :blogId';
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':blogId', $blogId, PDO::PARAM_INT);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($row) {
    // Display blog details
    echo '<main id="main" class="scrolled-offset">';
    echo '<section id="blog-single" class="blog-single">';
    echo '<div class="container" data-aos="fade-up">';
    echo '<div class="row">';
    echo '<div class="col-lg-12">';

    echo '<article class="entry entry-single">';
    echo '<div class="entry-img">';
    echo '<img src="data:image/jpeg;base64,' . base64_encode($row['blogImg']) . '" alt="" class="img-fluid">';
    echo '</div>';

    echo '<h2 class="entry-title">' . $row['blogName'] . '</h2>';

    echo '<div class="entry-meta">';
    echo '<ul>';
    echo '<li class="d-flex align-items-center"><i class="bi bi-person"></i> Treks in Nepal </li>';
    echo '<li class="d-flex align-items-center"><i class="bi bi-clock"></i> <time datetime="' . $row['publish_date'] . '">' . date('M d, Y', $row['publish_date']) . '</time></li>';
    echo '</ul>';
    echo '</div>';

    echo '<div class="entry-content">';
    echo '<p>' . $row['blogDescription'] . '</p>';
    echo '</div>';

    echo '</article><!-- End blog entry -->';

    echo '</div><!-- End col-lg-12 -->';
    echo '</div><!-- End row -->';
    echo '</div><!-- End container -->';
    echo '</section><!-- End Blog Single Section -->';
    echo '</main><!-- End #main -->';
  } else {
    echo '<p>Blog post not found.</p>';
  }
} else {
  echo '<p>Invalid blog ID.</p>';
}

include('layout/footer.php');
