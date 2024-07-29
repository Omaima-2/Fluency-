<?php
session_start();
include ("connect.php");
// Check if the user is logged in
if (isset($_SESSION['partner_id'])) // User is logged in, retrieve the user ID
  $user_id = $_SESSION['partner_id'];

$currentDate = date("Y-m-d");
$currentTime = date("H:i:s");

$sql = "SELECT * FROM requestsessions1 WHERE (Date >= '$currentDate' OR (Date = '$currentDate' AND time >= '$currentTime')) AND Status = 1 AND pID_req = $user_id";
$result = mysqli_query($conn, $sql);


?>
<!DOCTYPE html>
<html>

<head>
  <title>Current sessions</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8" />

  <link rel="icon" href="Logo.png" type="image/x.icon">
  <link rel="stylesheet" href="sessions.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css"
    integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous" />
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
  <h1>My Current sessions</h1>
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
              <li><a href="#">Current Sessions</a></li>
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

  <link href="sessions.css" rel="stylesheet">
  <main class="page-content">
    <?php
    // Check if there is any data in the result set
    if (($result) != null) {
      // Output data of each row
      while ($row = mysqli_fetch_assoc($result)) {
        //if ($row["Status"] == 1) {
        echo '<div class="card">';
        echo '<div class="content">';

        $sql1 = "SELECT * FROM lerner_info WHERE lerner_id = " . $row["LID_req"] . "";
        $result1 = mysqli_query($conn, $sql1);
        $info = mysqli_fetch_assoc($result1);
        echo '<h3 class="title">Name of Learner: ' . $info["Fname"] . ' ' . $info["Lname"] . '</h3>';//************** */
        echo '<p class="copy">Date: ' . $row["Date"] . '<br><br>' . 'Time:' . $row["time"] . '</p>';
        echo '<p class="copy">Session Duration: ' . $row["Duration"] . '</p>';
        echo '<p class="copy">Level of Learner: ' . $row["Level"] . '</p>';

        echo '</div></div>';
      }
    } else {
      echo "No previous sessions yet.";
    }
    ?>
  </main>
</body>

</html>