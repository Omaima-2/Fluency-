<?php
session_start();
include ("connect.php");


if (!isset($_SESSION['partner_id'])) {
  // Redirect user to login page or handle the case when user is not logged in
  header("Location: login.php");
  exit(); // Stop further execution
}

// Fetch user information based on session
$user_id = $_SESSION['partner_id'];
$sql = "SELECT * FROM partner_info WHERE partner_id = $user_id";
$result = mysqli_query($conn, $sql);

if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $firstName = $row['Fname'];
  $lastName = $row['Lname'];
  $email = $row['email'];
  $password = $row['password'];
  $age = $row['Age'];
  $gender = $row['Gender'];
  $phone = $row['phoneNumber'];
  $city = $row['City'];
  $language = $row['Language'];
  $proficiency = $row['ProficiencyLevel'];
  $sessionPrice = $row['SessionPrice'];
  $bio = $row['Bio'];
  //$photo = $row['photo'];
} else {
  // Handle the case when user information is not found
  echo "Error: User information not found.";
  exit(); // Stop further execution
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>My Profile</title>
  <link rel="stylesheet" type="text/css" href="ProfileP.css">
  <meta charset="UTF-8">
  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
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
      <img class="fluency-pic" src="LogoBlackBackground.PNG" alt="Flunecy">

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
              <li><a href="#">View profile</a></li>
              <li><a href="fluency.html">Sign out</a></li>
            </ul>
          </div>
        </li>
        <img src="ProfileIcon.png" alt="Profile" class="custom-img">
      </ul>
    </div>
    <!--**********************************************************-->
    <div class="backBtn">
      <a href="homePagePartner.php">
        <span class="line tLine"></span>
        <span class="line mLine"></span>
        <span class="label">Back </span>
        <span class="line bLine"></span>
      </a>
    </div>
  </nav>
  <div class="big-container">
    <div class="container">
      <form method="POST">
        <div class="header">
          <h1 class="myAccount">My Account</h1>
        </div>

        <div class="reviews-container">
          <button class="reviews-button"><a href="http://localhost/web/raitingAndReviewPartner.php">Check my
              reviews</a></button>
        </div>

        <img class="user-pic" id="user-pic" src="<?php echo $photo; ?>"><br>
        <input id="pic-file-name" type='file' />


        <div class="names-container">
          <label class="firstName-label">FirstName:</label>
          <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>">
          <label class="lastName-lable">Last Name:</label>
          <input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>">
        </div>


        <div class="email-password-container">
          <label class="email-lable">Email:</label>
          <input type="email" id="email" name="email" value="<?php echo $email; ?>">
          <label class="password-lable">Password:</label>
          <input type="password" id="password" name="password" value="<?php echo $password; ?>">
        </div>


        <div class="age-gender-container">
          <label class="age-lable">Age:</label>
          <input type="number" id="age" name="age" value="<?php echo $age; ?>">
          <label class="gender-lable">Gender:</label>
          <input type="text" id="gender" name="gender" value="<?php echo $gender; ?>">
        </div>


        <div class="phone-city-container">
          <label for="phone" class="phone-lable">Phone:</label>
          <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>">
          <label class="city-lable">City:</label>
          <input type="text" id="city" name="city" value="<?php echo $city; ?>">
        </div>


        <div class="proficiency-price-container">
          <div class="proficiency-section">
            <label class="proficiency-label">Proficiency:</label>
            <input type="text" id="proficiency" name="proficiency" value="<?php echo $proficiency; ?>">
          </div>
          <div class="price-section">
            <label class="price-label">Session Price:</label>
            <input type="text" id="sessionPrice" name="sessionPrice" value="<?php echo $sessionPrice; ?>">
          </div>
        </div>


        <div class="bio-container">
          <div class="culture-lable">Bio:</div>
          <textarea class="culture" id="culture" name="bio"><?php echo $bio; ?></textarea>
        </div>
        <button type="submit" class="save-button" name="submit">Save</button>


      </form>
    </div>
  </div>

  <?php
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Process form submission
    // Update user information in the database
    $firstname = $_POST['firstName'];
    $lastname = $_POST['lastName'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];
    $age = $_POST['age'];
    $eMail = $_POST['email'];
    $city = $_POST['city'];
    $phone = $_POST['phone'];
    $bio = $_POST['bio'];
    $proficiency = $_POST['proficiency'];
    $sessionPrice = $_POST['sessionPrice'];

    $sql1 = "UPDATE partner_info SET Fname='$firstName', Lname='$lastname', email='$eMail', password='$password', Age='$age', Gender='$gender', phoneNumber='$phone', City='$city', ProficiencyLevel='$proficiency', SessionPrice='$sessionPrice', Bio='$bio' WHERE partner_id = $user_id";
    $results1 = mysqli_query($conn, $sql1);

    if ($results1) {
      echo '<script>alert("Your edits have been saved successfully!");</script>';
    } else {
      echo "Error updating profile: " . $conn->error;
    }
  }
  ?>


  

</body>

</html>