<?php
session_start();
include ("connect.php");
// Check if the user is logged in
if (isset($_SESSION['learner_id'])) // User is logged in, retrieve the user ID
  $user_id = $_SESSION['learner_id'];

$currentDate = date("Y-m-d");
$currentTime = date("H:i:s");

$sql = "SELECT * FROM requestsessions1 WHERE (Date >= '$currentDate' OR (Date = '$currentDate' AND time >= '$currentTime')) AND Status = 1 AND LID_req = $user_id";
$result = mysqli_query($conn, $sql);


?>

<!DOCTYPE html>
<html>

<head>
  <title>Current sessions</title>
  <link rel="icon" href="Logo.png" type="image/x.icon">
  <meta charset="UTF-8" />

  <link href="sessions.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css"
    integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous" />
</head>

<body>
  <!--Back button-->
  <div class="backBtn">
    <a href="homePageLearner.php">
      <span class="line tLine"></span>
      <span class="line mLine"></span>
      <span class="label">Back </span>
      <span class="line bLine"></span>
    </a>
  </div>
  <h1>My current sessions </h1>

  <!-- Navbar Section -->
  <nav class="navbar">
    <div class="navbar__container">
      <img src="LogoBlackBackground.PNG" alt="Flunecy">

    </div>
    <div class="navbar__toggle" id="mobile-menu">
      <span class="bar"></span> <span class="bar"></span>
      <span class="bar"></span>
    </div>
    <ul class="navbar__menu">
      <li class="navbar__item">
        <a href="homePageLearner.php" class="navbar__links" id="home-page">Home</a>
      </li>


      <li class="navbar__item navbar__dropdown">
        <a href="#" class="navbar__links">Sessions</a>
        <div class="navbar__dropdown-content">
          <ul>
            <li><a href="#">Current Sessions</a></li>
            <li><a href="preSessionLearner.php">Previous Sessions</a></li>
          </ul>
        </div>
      </li>


      <li class="navbar__item">
        <a href="RequestLearner.php" class="navbar__links" id="partner-list-page">My Requests</a>
      </li>
      <li class="navbar__item navbar__dropdown">
        <a href="#" class="navbar__links">Profile</a>
        <div class="navbar__dropdown-content">
          <ul>
            <li><a href="ProfileLearner.php">View profile</a></li>
            <li><a href="fluency.html">Sign out</a></li>
          </ul>
        </div>
      </li>
      <img src="ProfileIcon.png" alt="Profile" class="custom-img">
    </ul>
    </div>
  </nav>

  <main class="page-content">
    <?php
    // Check if there is any data in the result set
    if (($result) != null) {
      // Output data of each row
      while ($row = mysqli_fetch_assoc($result)) {
        //if ($row["Status"] == 1) {
        echo '<div class="card">';
        echo '<div class="content">';

        $sql1 = "SELECT * FROM partner_info WHERE partner_id  = " . $row["pID_req"] . "";
        $result1 = mysqli_query($conn, $sql1);
        $info = mysqli_fetch_assoc($result1);
        echo '<h3 class="title">Name of Partner: ' . $info["Fname"] . ' ' . $info["Lname"] . '</h3>';//************** */
        echo '<p class="copy">Date: ' . $row["Date"] . '<br><br>' . 'Time:' . $row["time"] . '</p>';
        echo '<p class="copy">Session Duration: ' . $row["Duration"] . '</p>';
        echo '<p class="copy">Language: ' . $info["Language"] . '</p>';

        echo '</div></div>';
      }
    } else {
      echo "No previous sessions yet.";
    }
    ?>
  </main>
</body>

</html>