<?php

session_start();
include ("connect.php");

if (isset($_GET['partnerId']) && isset($_GET['partnerName'])) {
  $partnerID = $_GET['partnerId'];
  $partnerName = $_GET['partnerName'];
  // Fetch data from the database
  $sql = "SELECT * FROM partner_info WHERE partner_id = $partnerID";
  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result); // Fetch a single row from the result set
  } else {
    echo "Partner not found.";
  }
} else {
  echo "Invalid request.";
}
?>


<!DOCTYPE html>
<html>

<head>
  <title>Partner Info</title>
  <link rel="stylesheet" type="text/css" href="PartnerDetails.css">
  <meta charset="UTF-8">
  <link rel="shortcut icon" href="images/fav-icon.png" />
  <link rel="icon" href="Logo.png" type="image/x.icon">
  <!--poppins-font-family------------------->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
</head>

<body>

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
    <!--**********************************************************-->
    <div class="backBtn">
      <a href="listOfPartner1.php">
        <span class="line tLine"></span>
        <span class="line mLine"></span>
        <span class="label">Back </span>
        <span class="line bLine"></span>
      </a>
    </div>
  </nav>

  <div class="container">
      <label name="">Name: <?php echo $row['Fname'] . ' ' . $row['Lname']; ?> </label>

      <label>Bio: <?php echo $row['Bio']; ?> </label>
      <label>language spoken: <?php echo $row['Language']; ?> </label>
      <label>Proficiency level: <?php echo $row['ProficiencyLevel']; ?></label>
      <label>price per houre: <?php echo $row['SessionPrice']; ?></label>
      <label>You are welcome to contact me for initial disscusions: <a
          href="mailto:<?php echo $row['email']; ?>"><?php echo $row['email']; ?>Contact me</a></label>
      <label>Rating & Reviews: <a href="raitingAndReviewPartner.php?partner_id=<?php echo $partnerID; ?>">View Partner's
          Rating &
          Reviews</a></label>
  </div>

</body>

</html>