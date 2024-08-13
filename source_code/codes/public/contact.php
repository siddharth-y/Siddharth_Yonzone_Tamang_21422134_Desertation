<?php
include('layout/header.php');
include('layout/navigation.php');
include('admin/dbconnect.php');
// Initialize $aleartMessage variable
$aleartMessage = '';

if (isset($_POST['sumit_contact'])) {
  // Insert query
  $stmt = $pdo->prepare('INSERT INTO contacts (contactName, contactEmail, subject, message )
                         VALUES (:contactName, :contactEmail, :subject, :message)');

  $criteria = [
    ':contactName' => $_POST['contactName'],
    ':contactEmail' => $_POST['contactEmal'],
    ':subject' => $_POST['subject'],
    ':message' => $_POST['message'],

  ];

  $queryResult = $stmt->execute($criteria);

  if ($queryResult) {
    $_SESSION['message'] = 'Message Successfully Sent!';
    // Redirect to packages.php using JavaScript
    echo '<script>window.location.href = "contact.php";</script>';
  } else {
    $_SESSION['message'] = 'Error Sending Message!';
  }
}

?>

<main id="main" class="scrolled-offset">

  <!-- ======= Breadcrumbs ======= -->
  <section id="breadcrumbs" class="breadcrumbs">
    <div class="container">

      <ol>
        <li><a href="index.php">Home</a></li>
        <li>Contact</li>
      </ol>
      <h2>Contact</h2>

    </div>
  </section><!-- End Breadcrumbs -->

  <!-- ======= Contact Section ======= -->
  <section id="contact" class="contact">
    <div class="container">
      <?php if (isset($_SESSION['message'])) {
        echo ' <h5 class="alert alert-success">' . $_SESSION['message'] . '</h5>';
        unset($_SESSION['message']); // Clear the session message
      } ?>
      <div class="row">
        <div class="col-lg-6">
          <div class="info-box mb-4">
            <i class="bx bx-map"></i>
            <h3>Our Address</h3>
            <p>Boudha, Kathmandu, Nepal</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="info-box  mb-4">
            <i class="bx bx-envelope"></i>
            <h3>Email Us</h3>
            <p>treksinnepal@gmail.com</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="info-box  mb-4">
            <i class="bx bx-phone-call"></i>
            <h3>Call Us</h3>
            <p>+977 9884585423</p>
          </div>
        </div>

      </div>

      <div class="row">

        <div class="col-lg-6 ">
          <iframe class="mb-4 mb-lg-0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14127.239301324851!2d85.3598214!3d27.72315745!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb1bda4a951f0f%3A0x3ddabb234891c3bd!2sBuddha%20Stupa!5e0!3m2!1sen!2snp!4v1694541338818!5m2!1sen!2snp" frameborder="0" style="border:0; width: 100%; height: 384px;" allowfullscreen></iframe>
        </div>

        <div class="col-lg-6">
          <form action="forms/contact.php" method="post" role="form" class="php-email-form">
            <div class="row">
              <div class="col-md-6 form-group">
                <input type="text" name="contactName" class="form-control" id="name" placeholder="Your Name" required>
              </div>
              <div class="col-md-6 form-group mt-3 mt-md-0">
                <input type="email" class="form-control" name="contactEmail" id="email" placeholder="Your Email" required>
              </div>
            </div>
            <div class="form-group mt-3">
              <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
            </div>
            <div class="form-group mt-3">
              <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
            </div>
            <div class="my-3">
              <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">Your message has been sent. Thank you!</div>
            </div>
            <div class="text-center"><button type="submit" name="sumit_contact">Send Message</button></div>
          </form>
        </div>

      </div>

    </div>
  </section><!-- End Contact Section -->

</main><!-- End #main -->

<?php
include('layout/footer.php');
?>