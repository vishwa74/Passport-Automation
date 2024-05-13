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
$application_number = "";
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
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
  }

  .container p {
    color: #555;
  }

  .container button {
    padding: 10px 20px;
    background-color: #333;
    border: none;
    color: #fff;
    cursor: pointer;
    border-radius: 5px;
  }

  .container button:hover {
    background-color: #0056b3;
  }

  #application-number-container {
    max-width: 500px; /* Adjust container width */
  margin: 50px auto;
   background-color: #fff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    display: none;
  }

  #payment-result-container {
    max-width: 300px; /* Adjust container width */
  margin: 50px auto;
  background-color: #fff;
  
  }

  #track-application-container {
    max-width: 500px; /* Adjust container width */
  margin: 50px auto;
  background-color: #fff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
  }

</style>
</head>
<body>
<header>
    <div class="nav-left">
      <a href="index.html">Home</a>
    </div>
    <div class="nav-right">
      <a href="login.html">Login</a>
    </div>
  </header>
<div class="container">
    <h2>Passport Registration Success</h2>
    <p>Your passport details have been recorded.</p>
    <?php if(!empty($application_number)) { ?>
        <div id="application-number-container">
            <p>Your Application Number: <?php echo $application_number; ?></p>
            <p>You can use this number to track the status of your application.</p>
        </div>
    <?php } ?>
    <form id="payment-form" action="payment_success.php" method="POST">
        <label for="amount">Amount to Pay:250:</label>
        
        <button type="submit">Make Payment</button>
    </form>
</div>
<div  id="payment-result-container">
    <!-- Payment success image will be displayed here -->
</div>
<div class="container" id="track-application-container">
    <h2>Track Your Application</h2>
    <p>Click the button below to track your passport application:</p>
    <button onclick="location.href='trackappli.php';">Track Application</button>
</div>
<script>
document.getElementById("payment-form").addEventListener("submit", function(event) {
    event.preventDefault();
    // Simulate successful payment
    
        // Display payment success image
        var paymentResultContainer = document.getElementById("payment-result-container");
        paymentResultContainer.innerHTML = '<img src="rick.png" alt="Payment Success" style="max-width: 300px;">';
        // Display application number container
        document.getElementById("application-number-container").style.display = "block";
    
});
</script>
</body>
</html>
