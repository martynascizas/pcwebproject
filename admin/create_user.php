<?php
  // Connect to database
  require '../db.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the form data
$username = $_POST['username'];
$password = $_POST['password'];

// Hash the password using bcrypt
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert the new user into the admin table
$sql = "INSERT INTO admin (username, password) VALUES ('$username', '$hashed_password')";
if ($conn->query($sql) === TRUE) {
  echo "New user created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
