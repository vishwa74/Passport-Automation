<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "vedanth@123";
$dbname = "logindb";

// Check connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $full_name = $_POST['fullname'];
    $fathers_name = $_POST['fathersname'];
    $date_of_birth = $_POST['dob'];
    $nationality = $_POST['nationality'];
    $address = $_POST['address'];
    $phone_no = $_POST['phoneno'];
    $email = $_POST['email'];
    $aadhar_no = $_POST['aadharno'];
    $pan_no = $_POST['panno'];

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO passport_apply (fullname, fathersname, dob, nationality, address, phoneno, email, aadharno, panno) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $full_name, $fathers_name, $date_of_birth, $nationality, $address, $phone_no, $email, $aadhar_no, $pan_no);

    // Execute SQL statement
    if ($stmt->execute()) {
        // Retrieve the auto-generated application number
        $application_number = $conn->insert_id;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registration Success</title>
<style>body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

#registration-container {
  background-color: #fff;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  text-align: center;
}

#registration-container p {
  color: #555;
}

#registration-container button {
  padding: 10px 20px;
  background-color: #007bff;
  border: none;
  color: #fff;
  cursor: pointer;
  border-radius: 5px;
}

#registration-container button:hover {
  background-color: #0056b3;
}

</style>
</head>
<body>
<div style="text-align: center; margin-top: 100px;" id="registration-container">
    <h2>Passport Registration Success</h2>
    <p>Your passport details have been recorded.</p>
    <?php if(isset($application_number)) { ?>
        <p>Your Application Number: <?php echo $application_number; ?></p>
        <p>You can use this number to track the status of your application.</p>
    <?php } ?>
</div>
<div style="text-align: center; margin-top: 100px;" id="registration-container">
    <h2>Track Your Application</h2>
    <p>Click the button below to track your passport application:</p>
    <button onclick="location.href='trackappli.php';">Track Application</button>
</div>
</body>
</html>
