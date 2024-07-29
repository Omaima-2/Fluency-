<?php
session_start();
include ("connect.php");

// Check if the user is logged in
if (isset($_SESSION['learner_id'])) // User is logged in, retrieve the user ID
  $user_id = $_SESSION['learner_id'];



// Fetch data from the database
$sql = "SELECT * FROM partner_info";
$result = mysqli_query($conn, $sql);


?>


<!DOCTYPE html>
<html>

<head>
  <title>Partner List</title>

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="ListOfpartner1.css" />

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
  <h1>List Of Partner</h1>
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
        <a href="RequestLearner.php" class="navbar__links" id="partner-list-page">My Requests</a>
      </li>
      <li class="navbar__item navbar__dropdown">
        <a href="#" class="navbar__links">Profile</a>
        <div class="navbar__dropdown-content">
          <ul>
            <li><a href="ProfileLearner.php">View profile</a></li>
            <li><a href="fluency.html" id="singout">Sign out</a></li>
          </ul>
        </div>
      </li>
      <img src="ProfileIcon.png" alt="Profile" class="custom-img">


    </ul>
  </nav>
  <main class="page-content">
    <?php
    // Check if there is any data in the result set
    if ($result->num_rows > 0) {
      // Output data of each row
      while ($row = $result->fetch_assoc()) {
        echo '<div class="card">';
        echo '<div class="content">';
        echo '<form method="GET" class="partner-form" >';

        echo '<input type="hidden" name="partnerId" value="' . $row["partner_id"] . '">';
        echo '<input type="hidden" name="partnerName" value="' . $row["Fname"] . '">';
        echo '<p class="title">Language: ' . $row["Language"] . '</p>';
        echo '<p class="title">Partner Name: ' . $row["Fname"] . " " . $row["Lname"] . '</p>';
        echo '<p class="title">Proficiency Level: ' . $row["ProficiencyLevel"] . '</p>';
        echo '<button type="submit" id="moreDetailsButton">Partner Details</button>';
        echo '<button type="submit" id="postRequestButton" name="postRequestButton">Post Request</button>';
        echo '</div></div></form>';
      }
    } else {
      echo "0 results";
    }
    ?>
  </main>

  <script>
    // JavaScript to handle form submission based on button click
    document.querySelectorAll('.partner-form').forEach(function (form) {
      form.querySelector('#moreDetailsButton').addEventListener('click', function () {
        // Set form action to "more_details.php"
        form.action = 'Partner_moreInfo.php';
        // Submit the form
        form.submit();
      });

      form.querySelector('#postRequestButton').addEventListener('click', function () {
        // Set form action to "postRequest.php"
        form.action = 'postRequest.php';
        // Submit the form
        form.submit();
      });
    });
  </script>




</body>

</html>