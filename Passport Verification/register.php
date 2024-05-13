<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "vedanth@123";
$dbname = "logindb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$user_type = $_POST['user_type'];
$pin = isset($_POST['pin']) ? $_POST['pin'] : null;

// Check if passwords match
if ($password !== $confirm_password) {
  die("Passwords do not match");
}

// If PIN is provided, verify it
if (!empty($pin)) {
  if ($pin !== "sarapassport") {
    die("Invalid PIN"); // Stop registration if PIN is not "AAA"
  }
}

// If user type is "Applicant" or PIN is verified, proceed with registration
$stmt = $conn->prepare("INSERT INTO usertable (username, password, usertype) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $password, $user_type);
$stmt->execute();

echo "Registration successful";

$stmt->close();
$conn->close();

header("Location: index.html");
exit();

?>
