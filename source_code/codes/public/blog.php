<?php
include('layout/header.php');
include('layout/navigation.php');
include('admin/dbconnect.php'); // Include your database connection script

// Fetch blogs from the database
$sql = 'SELECT * FROM blogs';
$result = $pdo->query($sql);

?>

<main id="main" class="scrolled-offset">
  <!-- ... -->

  <!-- ======= Blog Section ======= -->
  <section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
      <div class="row">
        <div class="col-lg-8 entries">
          <?php
          while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<article class="entry">';
            echo '<div class="entry-img">';
            echo '<img src="admin/assets/img/blog/' . $row['blogImg'] . '" alt="' . $row['blogTitle'] . '" class="img-fluid">';
            echo '</div>';

            echo '<h2 class="entry-title">';
            echo '<a href="blog-single.php?id=' . $row['blogId'] . '">' . $row['blogTitle'] . '</a>';
            echo '</h2>';

            echo '<div class="entry-meta">';
            echo '<ul>';
            echo '<li class="d-flex align-items-center"><i class="bi bi-calendar"></i> ' . date('M d, Y', $row['publish_date']) . '</li>'; // Display date without time
            echo '<li class="d-flex align-items-center"><i class="bi bi-person"></i> Treks in Nepal</li>'; // Always display "Treks in Nepal" as the author
            echo '</ul>';
            echo '</div>';

            echo '<div class="entry-content">';
            // Display one paragraph of the description followed by "..."
            $descriptionParagraphs = explode("\n", $row['blogDescription']);
            echo '<p>' . $descriptionParagraphs[1] . '...</p>';
            echo '</div>';

            // Modify the button to redirect to blog-single.php
            echo '<div class="read-more">';
            echo '<a href="blog-single.php?id=' . $row['blogId'] . '" class="btn btn-primary">Read More</a>';
            echo '</div>';

            echo '</article><!-- End blog entry -->';
          }
          ?>
        </div><!-- End blog entries list -->

        <!-- Add your sidebar content here -->

      </div>
    </div>
  </section><!-- End Blog Section -->
</main><!-- End #main -->

<?php
include('layout/footer.php');
?>