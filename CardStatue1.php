<?php
session_start();
include ("connect.php");
if (isset($_SESSION['partner_id']))
  $user_id = $_SESSION['partner_id'];
?>

<!DOCTYPE html>
<html>

<head>
  <title> Requests Statue </title>
  <link rel="icon" href="Logo.png" type="image/x.icon">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="Logo.png" type="image/x.icon">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css"
    integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous" />
  <link href="CardStatue1.css" rel="stylesheet">
</head>

<body>
  <!--Back button-->
  <div class="backBtn">
    <a href="homePagePartner.php">
      <span class="line tLine"></span>
      <span class="line mLine"></span>
      <span class="label">Back </span>
      <span class="line bLine"></span>
    </a>
  </div>
  <!--End Back button-->
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





        <img src="ProfileIcon.png" alt="Profile" class="custom-img">


      </ul>
    </div>
  </nav>
  <br>

  <?php
  // Assuming you have already established a database connection
// Retrieve data from the database
  $query = "SELECT rs.*, L.*
  FROM requestsessions1 rs
  INNER JOIN lerner_info L ON rs.LID_req  = L.lerner_id 
  WHERE rs.pID_req = $user_id AND  Status <> 0";
  $result = mysqli_query($conn, $query);

  // Display the cards
  echo '<h1>My Requests</h1>';
  echo '<link href="ListOfRequest.css" rel="stylesheet">';
  echo '<main class="page-content">';
  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      $Pid = $row['pID_req'];
      $Lid = $row['LID_req'];
      $name = $row['Fname'];
      $Lname = $row['Lname'];
      // $goal = $row['goal'];
      //$language = $row['language'];
      //$proficiency = $row['proficiency'];
      $duration = $row['Duration'];
      $Level = $row['Level'];
      $date = $row['Date'];
      //$email = $row['email'];
      $time = $row['time'];
      $currentTime = time();
      $status = $row['Status'];
      // ... existing code ...
  
      echo '<div class="card">';
      echo '<div class="content">';
      if ($status == 1) {
        echo '<img class="approved-rejected-icon" src="accept.png" width="30px" alt="Accept icon">';
        echo '<div class="space"></div>';
        echo '<h2 class="title">' . $name . ' ' . $Lname . '</h2>';
        //echo '<p class="copy">Goal: ' . $goal . '<br>';
        echo 'Level: ' . $Level . '<br>';
        echo 'start Time : ' . $time . '<br>';
        echo 'Duration: ' . $duration . '</p>';
      } else if ($status == 2) {
        echo '<img class="approved-rejected-icon" src="reject.png" width="30px" alt="reject icon">';
        echo '<div class="space"></div>';
        echo '<h2 class="title">' . $name . ' ' . $Lname . '</h2>';
        //echo '<p class="copy">Goal: ' . $goal . '<br>';
        echo 'Level: ' . $Level . '<br>';
        echo 'start Time : ' . $time . '<br>';
        echo 'Duration: ' . $duration . '</p>';
      }
      echo '</div>';
      echo '</div>';
    }
  } else {
    echo 'you dont accssept or reject any requese';
  }
  ?>
</body>

</html>