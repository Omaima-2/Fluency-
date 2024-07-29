<?php
session_start();
include ("connect.php");
if (!isset($_SESSION['learner_id'])) {
  // Redirect user to login page or handle the case when user is not logged in
  header("Location:signinLearner.php");
  exit(); // Stop further execution
}

// Fetch user information based on session
$user_id = $_SESSION['learner_id'];
$sql = "SELECT * FROM lerner_info WHERE lerner_id = $user_id";
$result = mysqli_query($conn, $sql);

if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $firstName = $row['Fname'];
  $lastName = $row['Lname'];
  $email = $row['email'];
  $password = $row['password'];
  $location = $row['location'];
  $city = $row['city'];
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
  <link rel="stylesheet" type="text/css" href="ProfileLearner.css">
  <meta charset="UTF-8">
  <link rel="icon" href="Logo.png" type="image/x.icon">
  <link rel="shortcut icon" href="images/fav-icon.png" />
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
            <li><a href="#">View profile</a></li>
            <li><a href="fluency.html">Sign out</a></li>
          </ul>
        </div>
      </li>
      <img src="images\ProfileIcon.png" alt="Profile" class="custom-img">
    </ul>
    </div>
  </nav>

  <!--  ********************************************  -->
  <div class="backBtn">
    <a href="homePageLearner.php">
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

        <img class="user-pic" id="user-pic" src="<?php echo $photo; ?>"><br>
        <input id="pic-file-name" type='file' />


        <!-- <script type="text/javascript">
          window.addEventListener('load', function() {
     document.querySelector('input[type="file"]').addEventListener('change', function() {
         if (this.files && this.files[0]) {
             var img = document.getElementById('user-pic');
             img.onload = () => {
                 URL.revokeObjectURL(img.src);  // no longer needed, free memory
             }
   
             img.src = URL.createObjectURL(this.files[0]); // set src to blob url
         }
     });
   });
       
       </script>
  -->

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



        <div class="location-city-container">
          <label class="location-label">Location:</label>
          <input type="text" id="location" name="location" value="<?php echo $location; ?>">

          <label class="city-lable">City:</label>
          <input type="text" id="city" name="city" value="<?php echo $city; ?>">
          <button type="submit" class="save-button" name="submit">Save</button>


      </form>
    </div>
  </div>




  <?php
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $firstname = $_POST['firstName'];
    $lastname = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $location = $_POST['location'];
    $city = $_POST['city'];

    // Execute the update query after defining $results1
    $sql1 = "UPDATE lerner_info SET Fname='$firstName', Lname='$lastname', email='$email', password='$password', location='$location', city='$city' WHERE lerner_id = $user_id";
    $results1 = mysqli_query($conn, $sql1);

    if ($results1) {
      echo '<script>alert("Your edits have been saved successfully!");</script>';
      // Redirect or perform any additional action after successful update
    } else {
      echo "Error updating profile: " . $conn->error;
    }
  }
  ?>



</body>

</html>