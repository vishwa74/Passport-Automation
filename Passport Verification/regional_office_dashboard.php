<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Regional Administrator Dashboard</title>
<style>
  body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  margin: 0;
  padding: 0;
  
}

header {
  max-width: 500px; /* Adjust container width */
  margin: 50px auto;
  border-radius: 10px;
  background-color: #fff;
  border-bottom: 1px solid #ddd;
  padding:  20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.nav-left, .nav-right {
  display: flex;
  align-items: center;
}

.nav-left a, .nav-right a {
  text-decoration: none;
  color: #333;
  margin-right: 20px;
  padding: 8px 15px;
  border-radius: 5px;
  background-color: #333;
  color: #fff;
}

.container {
  max-width: 500px; /* Adjust container width */
  margin: 50px auto;
  background-color: #fff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.record {
  background-color: #fff;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  text-align: center;
  margin-bottom: 20px;
}

.record label {
  font-weight: bold;
  margin-bottom: 5px;
  display: block;
}

.record p {
  margin-top: 5px;
}

.actions {
  margin-top: 20px;
}

.actions a {
  margin-right: 10px;
}

button {
  width: calc(100% - 22px); /* Adjust width */
  padding: 10px;
  margin-bottom: 10px;
  border-radius: 5px;
  border: 1px solid #ccc;
}

button {
  background-color: #333;
  color: #fff;
  border: none;
  cursor: pointer;
}

button:hover {
  background-color: #555;
}

</style>
</head>
<body>
<header>
    <div class="nav-left">
      <a href="index.html">Home</a>
    </div>
    <p>Regional Administration Office</p>
    <div class="nav-right">
      <a href="login.html">Logout</a>
    </div>
  </header>
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

// Default to first record
$current_index = 0;

// Check if index is set in URL parameters
if (isset($_GET['index'])) {
    $current_index = $_GET['index'];
}

// Fetch records from database
$sql = "SELECT * FROM passport_apply ORDER BY appl_no LIMIT $current_index, 1";
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}

if ($result->num_rows > 0) {
    // Output data of the current record
    $row = $result->fetch_assoc();
    echo "<div class='container'>";
    echo "<div class='record'>";
    echo "<label>Application Number:</label><p>" . $row["appl_no"] . "</p>";
    echo "<label>Full Name:</label><p>" . $row["fullname"] . "</p>";
    echo "<label>Father's Name:</label><p>" . $row["fathersname"] . "</p>";
    echo "<label>Date of Birth:</label><p>" . $row["dob"] . "</p>";
    echo "<label>Nationality:</label><p>" . $row["nationality"] . "</p>";
    echo "<label>Address:</label><p>" . $row["address"] . "</p>";
    echo "<label>Phone Number:</label><p>" . $row["phoneno"] . "</p>";
    echo "<label>Email:</label><p>" . $row["email"] . "</p>";
    echo "<label>Aadhar Number:</label><p>" . $row["aadharno"] . "</p>";
    echo "<label>PAN Number:</label><p>" . $row["panno"] . "</p>";
    echo "<label>Status:</label><p>" . $row["status"] . "</p>";
    echo "</div>";
    echo "<div class='actions'>";
    // Previous button
    if ($current_index > 0) {
        echo "<a href='regional_office_dashboard.php?action=previous&index=" . ($current_index - 1) . "'><button>Previous</button></a>";
    }
    // Next button
    if ($result->num_rows > 0) {
        echo "<a href='regional_office_dashboard.php?action=next&index=" . ($current_index + 1) . "'><button>Next</button></a>";
    }
    // Verify button
    echo "<a href='regional_office_dashboard.php?action=verify&appl_no=" . $row["appl_no"] . "'><button>Verify Application</button></a>";
    // Reject button
    echo "<a href='regional_office_dashboard.php?action=reject&appl_no=" . $row["appl_no"] . "'><button>Reject Application</button></a>";
    echo "</div>";
    echo "</div>";
} else {
    echo "No records tp verify left";
}

// Process action (Verify or Reject)
if (isset($_GET['action']) && ($_GET['action'] == 'verify' || $_GET['action'] == 'reject') && isset($_GET['appl_no'])) {
    $action = $_GET['action'];
    $appl_no = $_GET['appl_no'];

    // Update status column in the database
    $status = ($action == 'verify') ? 'Verified by RAO' : 'Rejected by RAO,Penalty Issued';
    $update_sql = "UPDATE passport_apply SET status='$status' WHERE appl_no='$appl_no'";
    if ($conn->query($update_sql) === TRUE) {
        echo "<div class='record'><p>Record with Application Number: " . $appl_no . " has been updated successfully.</p></div>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
</body>
</html>
