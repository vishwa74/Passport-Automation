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

// Retrieve username and password from form
$username = $_POST['username'];
$password = $_POST['password'];

// SQL query to check if user exists
$sql = "SELECT * FROM usertable WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows==1) {
  echo "Result fetched";
  // Redirect to dashboard based on user role
  $row = $result->fetch_assoc();
  $role = $row['usertype'];
  switch ($role) {
    case 'Applicant':

      header("Location: applicant_dashboard.html");
      break;
    case 'admin':
      header("Location: admin_dashboard.php");
      break;
    case 'regional_office':
      header("Location: regional_office_dashboard.php");
      break;
    case 'police':
      header("Location: police_dashboard.php");
      break;
    default:
      echo "Invalid role";
  }
} else {
  echo "Invalid username or password. Please try again.";
}

$conn->close();
?>
