<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Track Application</title><style>
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
  #registration-container {
    max-width: 500px; /* Adjust container width */
  margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin-top: 100px;
  }

  #registration-container h2 {
    font-size: 24px;
    color: #333;
  }

  #registration-container form {
    margin-top: 20px;
  }

  #registration-container form label {
    color: #555;
    font-weight: bold;
  }

  #registration-container form input[type="text"],
  #registration-container form input[type="date"] {
    padding: 10px;
    margin: 10px;
    width: 100%;
    box-sizing: border-box;
    border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  #registration-container form button {
    padding: 10px 20px;
    background-color: #333;
    border: none;
    color: #fff;
    cursor: pointer;
    border-radius: 5px;
  }

  #registration-container form button:hover {
    background-color: #0056b3;
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
<div id="registration-container">
    <h2>Track Your Application</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="tracking_number">Tracking Number:</label>
        <input type="text" id="tracking_number" name="tracking_number" required><br><br>
        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" id="date_of_birth" name="date_of_birth" required><br><br>
        <button type="submit">Track Application</button>
    </form>



    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $tracking_number = $_POST['tracking_number'];
    $date_of_birth = $_POST['date_of_birth'];

    // Prepare and execute SQL statement to search for application status and address
    $stmt = $conn->prepare("SELECT status, address FROM passport_apply WHERE appl_no = ? AND dob = ?");
    $stmt->bind_param("ss", $tracking_number, $date_of_birth);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Application status and address found, display them
        $row = $result->fetch_assoc();
        $status = $row["status"];
        $address = $row["address"];
        echo "<p>Application Status: $status</p>";

        if ($status == "Verified by Police") {
            echo "<div style='background-color: #e6ffe6; padding: 10px; margin-top: 20px;'>";
            echo "<p>Passport will be generated and will be delivered to the following address:</p>";
            echo "<p>$address</p>";
            echo "</div>";
        }
    } else {
        // Application not found
        echo "<p>No application found with the provided tracking number and date of birth.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

</div>
</body>
</html>
