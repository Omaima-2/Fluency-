<?php
include ("connect.php");
session_start();

if (isset($_SESSION['partner_id']))
  $partner_id = $_SESSION['partner_id'];

// Retrieve data from the database
$query = "SELECT rs.*, L.*
FROM requestsessions1 rs
INNER JOIN lerner_info L ON rs.LID_req  = L.lerner_id 
WHERE rs.pID_req = $partner_id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
  <title>My Request </title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="ListOfRequest.css" />

  <link rel="icon" href="Logo.png" type="image/x.icon">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css"
    integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
</head>

<body>
  <!-- Back button -->
  <div class="backBtn">
    <a href="homePagePartner.php">
      <span class="line tLine"></span>
      <span class="line mLine"></span>
      <span class="label">Back </span>
      <span class="line bLine"></span>
    </a>
  </div>

  <!-- Navbar Section -->
  <nav class="navbar">
    <div class="navbar__container">
      <img src="LogoBlackBackground.PNG" alt="Flunecy">

      <div class="navbar__toggle" id="mobile-menu">
        <span class="bar"></span> <span class="bar"></span>
        <span class="bar"></span>
      </div>
      <ul class="navbar__menu">
        <li class="navbar__item">
          <a href="homePagePartner.php" class="navbar__links" id="home-page">Home</a>
        </li>

        <li class="navbar__item navbar__dropdown">
          <a href="#" class="navbar__links">Sessions</a>
          <div class="navbar__dropdown-content">
            <ul>
              <li><a href="currentSessionPartner.php">Current Sessions</a></li>
              <li><a href="preSessionPartner.php">Previous Sessions</a></li>
            </ul>
          </div>
        </li>

        <li class="navbar__item navbar__dropdown">
          <a href="#" class="navbar__links">Profile</a>
          <div class="navbar__dropdown-content">
            <ul>
              <li><a href="ProfilePartner.php">View profile</a></li>
              <li><a href="fluency.html">Sign out</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Display Requests -->
  <h1>My Requests</h1>
  <main class="page-content">
    <?php
    // Check if there is any data in the result set
    if ($result->num_rows > 0) {
      // Output data of each row
      while ($row = mysqli_fetch_assoc($result)) {
        if ($row['Status'] == 0) {
          $Pid = $row['pID_req'];
          $Lid = $row['LID_req'];
          $name = $row['Fname'];
          $Lname = $row['Lname'];
          $duration = $row['Duration'];
          $Level = $row['Level'];
          $date = $row['Date'];
          $email = $row['email'];
          $time = $row['time'];
          $status = $row['Status'];
          $createdTime = strtotime($row['time']);
          $currentTime = time();
          $timeDiff = $currentTime - $createdTime;
          $card = $row['cardID'];
          $daysDiff = floor($timeDiff / (60 * 60 * 24)); // Calculate the time difference in days    


          echo '<div class="card" id="card">';
          echo '<div class="content">';
          echo '<form method="POST" class="field button-field">';
          echo '<input type="hidden" name="Pid" value="' . $Pid . '">';
          echo '<input type="hidden" name="request_id" value="' . $card . '">';
          echo '<input type="hidden" name="Lid" value="' . $Lid . '">';
          echo '<input type="hidden" name="date" value="' . $date . '">';
          echo '<input type="hidden" name="time" value="' . $time . '">';
          echo '<p class="copy">Learner name: ' . $name . " " . $Lname . '</p>';
          echo '<p class="copy">level: ' . $Level . '</p>';
          echo '<p class="copy">Session date: ' . $date . '</p>';
          echo '<p class="copy">Session start: ' . $time . '</p>';
          echo '<p class="copy">duration: ' . $duration . '</p>';
          echo '<p class="copy">To Contact: <a href="mailto:' . $email . '"><img src="mail.png" width="20px" alt="Email icon"></a></p>';
          echo '<input type="submit" name="bt"  value="Accept"  class="green-button" style="background-color:green; color: white; padding: 5px 5px;text-decoration: none">';
          echo '<input type="submit" name="bt2"  value="Reject" class="red-button" style="background-color:red; color: white; padding: 5px 5px;text-decoration: none">';
          echo '</div></div></form>';

          // Update the status to "reject" if it has been pending for more than two minutes
    
          if ($daysDiff > 2) {
            $updateQuery = "UPDATE requestsessions1 SET Status = 2 WHERE cardID = $card ";
            mysqli_query($conn, $updateQuery);
            //$status = 2; // Update the status variable for rendering the card
        }
        }

      }
    } else {
      echo "<script>alert('No requests');</script>";
    }
    ?>
    <?php
    if (isset($_POST["bt"])) {
      $request_id = $_POST["request_id"] ?? null; // Use null coalescing operator
    
      if ($request_id !== null) { // Check if $request_id is not null
        $updateQuery = "UPDATE requestsessions1 SET Status = 1 WHERE cardID = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);
        if ($stmt) {
          mysqli_stmt_bind_param($stmt, "i", $request_id);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_close($stmt);
        } else {
          echo "Prepare failed: " . mysqli_error($conn);
        }
      }
    } elseif (isset($_POST["bt2"])) {
      $request_id = $_POST["request_id"] ?? null; // Use null coalescing operator
    
      if ($request_id !== null) { // Check if $request_id is not null
        $updateQuery1 = "UPDATE requestsessions1 SET Status = 2 WHERE cardID = ?";
        $stmt = mysqli_prepare($conn, $updateQuery1);
        if ($stmt) {
          mysqli_stmt_bind_param($stmt, "i", $request_id);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_close($stmt);
        } else {
          echo "Prepare failed: " . mysqli_error($conn);
        }
      }
    } ?>

  </main>

</body>

</html>