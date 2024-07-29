<?php
session_start();
include ("connect.php");

if (isset($_SESSION['learner_id']))
  $learnerID = $_SESSION['learner_id'];


?>
<!DOCTYPE html>
<html>

<head>
  <title>My Request </title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="ListOfRequest.css">

  <link rel="icon" href="Logo.png" type="image/x.icon">
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
  <!--End Back button-->
  <h1>My Requests </h1>
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
            <li><a href="currentSessionLearner.php">Current Sessions</a></li>
            <li><a href="preSessionLearner.php">Previous Sessions</a></li>
          </ul>
        </div>
      </li>


      <li class="navbar__item">
        <a href="#" class="navbar__links" id="partner-list-page">My Requests</a>
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
    $sql = "SELECT *  FROM requestsessions1 WHERE Status = 0 AND LID_req = $learnerID";
    $result = mysqli_query($conn, $sql);

    // Check if there is any data in the result set
    if ($result) {
      // Output data of each row
      while ($row = mysqli_fetch_assoc($result)) {
        $Pid = $row['pID_req'];
        $Lid = $row['LID_req'];
        $duration = $row['Duration'];
        $Level = $row['Level'];
        $date = $row['Date'];
        $time = $row['time'];
        $status = $row['Status'];
        $card = $row['cardID'];
        $sql2 = "SELECT *  FROM partner_info WHERE  partner_id  = $Pid";
        $result2 = mysqli_query($conn, $sql2);
        $par = mysqli_fetch_assoc($result2);
        echo '<div class="card" id="card">';
        echo '<div class="content">';
        echo '<form method="POST" action="editReqLearner.php" class="field button-field">';
        echo '<input type="hidden" name="Pid" value="' . $Pid . '">';
        echo '<input type="hidden" name="request_id" value="' . $card . '">';
        echo '<input type="hidden" name="Lid" value="' . $Lid . '">';
        echo '<input type="hidden" name="date" value="' . $date . '">';
        echo '<input type="hidden" name="time" value="' . $time . '">';
        echo '<h3 class="title">Partner name: ' . $par['Fname'] . ' ' . $par['Lname'] . '</h3>';
        echo '<p class="copy">level: ' . $Level . '</p>';
        echo '<p class="copy">Session date: ' . $date . '</p>';
        echo '<p class="copy">Session start: ' . $time . '</p>';
        echo '<p class="copy">duration: ' . $duration . '</p>';
        echo '<input type="submit" name="edit"  value="more detalis"  class="green-button" style="background-color:green; color: white; padding: 5px 5px;text-decoration: none">';
        echo '</div></div></form>';
      }
    } else {
      echo "<script>alert('No requests');</script>";
    }
    ?>
  </main>
</body>

</html>