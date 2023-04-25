<!DOCTYPE html>
<html lang="en">

<?php
require_once 'components/head.php';
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .card {
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .card-header {
      background-color: #f8f9fa;
    }

    .form-control:focus {
      box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
    }

    .center {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
  </style>
</head>

<body>
  <?php
  session_start();

  // Connect to database
  require '../db.php';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate username and password
    if (empty(trim($username))) {
      $error = "Please enter your username.";
    } else if (empty(trim($password))) {
      $error = "Please enter your password.";
    } else {
      // Input is valid
    }

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Check if username and password match an admin in the database
    $sql = "SELECT * FROM admin WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
      $admin = $result->fetch_assoc();
      if (password_verify($password, $admin['password'])) {
        // Login successful
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: index.php");
        exit;
      }
    }

    // Login failed
    $error = "Invalid username or password";
  }

  // If the user is already logged in, redirect to index.php
  if (isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
  }

  ?>
  <div class="center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <?php if (isset($error)) { ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $error; ?>
            </div>
          <?php } ?>
          <form action="login.php" method="post">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
          </form>
          <div style="margin-top: 20px;">
            <a href="http://localhost/project/index.php">devėtas.lt</a>
            <!-- <a href="https://parduosiu.lt/devetas/">devėtas.lt</a> -->
          </div>
        </div>
      </div>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.min.js"></script>
    </div>
  </div>

</body>

</html>