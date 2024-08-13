<?php
session_start();
ob_start(); // Start output buffering
include('layouts/loginlayout.php');
include('dbconnect.php');

$login_error = '';

if (isset($_POST['submit'])) {
  // Get user input from the form
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Prepare and execute a SQL query to fetch user data based on username
  $stmt = $pdo->prepare('SELECT userId, username, password FROM admin WHERE username = :username');

  // Bind the username parameter
  $stmt->bindParam(':username', $username);

  // Execute the query
  $stmt->execute();

  // Fetch the user data
  $admin = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($admin) {
    // Verify the entered password against the hashed password in the database
    if (password_verify($password, $admin['password'])) {
      // Password is correct
      $_SESSION['userId'] = $admin['userId'];
      $_SESSION['username'] = $admin['username'];
      $_SESSION['loggedin'] = true;
      // Redirect to the dashboard or another page
      header('Location: index.php');
      exit(); // Ensure that no further code is executed after redirection
    } else {
      // Password is incorrect
      $login_error = "Invalid username or password.";
    }
  } else {
    // User not found
    $login_error = "Invalid username or password.";
  }
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  // User is logged in, you can add your code here for logged-in users
}

ob_end_flush(); // Flush the output buffer
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Add your HTML head content here -->
</head>

<body>
  <!-- Your HTML body content here -->

  <!-- Login Form -->
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <!-- Add your login form HTML content here -->
        <div class="container">
          <!-- Add your login form HTML content here -->
          <?php if (isset($_SESSION['message'])) {
            echo ' <h5 class="alert alert-success">' . $_SESSION['message'] . '</h5>';
            unset($_SESSION['message']); // Clear the session message
          } ?>
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="d-flex justify-content-center py-4">
                <a href="" class="logo d-flex align-items-center ">
                  <img src="assets/img/logo.jpg" alt="">
                  <span class="d-none d-lg-block">Treks in Nepal</span>
                </a>
              </div>
              <div class="card mb-3">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>
                  <form class="row g-3 needs-validation" novalidate method="POST">
                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="username" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" name="submit" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Don't have an account? <a href="register.php">Create an account</a></p>
                    </div>
                  </form>
                  <?php if ($login_error) : ?>
                    <div class="alert alert-danger mt-3"><?php echo $login_error; ?></div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>

  <!-- Include your footer content here -->
</body>

</html>