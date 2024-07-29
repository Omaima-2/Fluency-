<?php
session_start();
include ("connect.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $Fname = $_POST['FirstName'];
  $lastName = $_POST['lastName'];
  $email = $_POST['Email'];
  $PhoneNumber = $_POST['PhoneNumber'];
  $password = $_POST['Password'];
  $City = $_POST['City'];
  $Age = $_POST['Age'];
  $Language = $_POST['Language'];
  $Bio = $_POST['Bio'];
  $Gender = $_POST['gender'];
  $email = $_POST['email']; // Assuming the email is submitted via a form
//SELECT email FROM lerner_info WHERE email = $email
  // Prepare the SQL query
  $sql = "SELECT email FROM partner_info WHERE email =  $email";
  $result = mysqli_query($conn, $sql);
  
  // Fetch the result
  if ($resu = mysqli_fetch_assoc($result)) {
      // Email exists in either learner or partner table
      echo "Email already exists in the database.";
  } else {
  $query = "INSERT into partner_info(Fname,Lname,email,PhoneNumber,Password,City, Age,Language, Bio,Gender) values ('$Fname','$lastName','$email','$PhoneNumber','$password','$City','$Age','$Language','$Bio','$Gender')";
  if (mysqli_query($conn, $query)) {
    // Insertion successful, retrieve the auto-generated partner ID
    $partnerID = mysqli_insert_id($conn);

    // Save the partner ID into the session
    $_SESSION['partner_id'] = $partnerID;

    // Redirect to the home page
    header("location: homePagePartner.php");
  } else {
    // Insertion failed
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
    // Optionally, redirect back to the form page or display an error message
  }
}/// لا ننسى نحط عدم الدخول
/// لا ننسى نحط عدم الدخول
}
?>








<!DOCTYPE html>
<!-- Created By CodingLab - www.codinglabweb.com -->
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title> Sign Up </title>
  <link rel="stylesheet" href="stylepartner.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="Logo.png" type="image/x.icon">
</head>

<body>
  <div class="container">
    <div class="title">Sign Up</div>
    <div class="content">
      <form method="post">
        <div class="user-details">
          <div class="input-box">
            <!--add name attr for each box-->
            <span class="details">First Name <span style="color: red;">*</span></span>
            <input type="text" name="FirstName" placeholder="Enter your First name" minlength="2" maxlength="10"
              name="firstname" required>
          </div>
          <div class="input-box">
            <span class="details">Last Name<span style="color: red;">*</span></span>
            <input type="text" name="lastName" placeholder="Enter your Last name" minlength="3" maxlength="20"
              name="lastname" required>
          </div>
          <div class="input-box">
            <span class="details">Email<span style="color: red;">*</span></span>
            <input type="text" name="Email" placeholder="Enter your email" name="email" minlength="11" maxlength="30"
              required>
          </div>
          <div class="input-box">
            <span class="details">Phone Number<span style="color: red;">*</span></span>
            <input type="text" name="PhoneNumber" placeholder="Enter your number" name="phonenum" minlength="10"
              maxlength="12" required>
          </div>
          <div class="input-box">
            <span class="details">Password<span style="color: red;">*</span></span>
            <input type="password" name="Password" placeholder="Enter your password" name="pass" minlength="10"
              maxlength="30" required>
          </div>

          <div class="input-box">
            <span class="details">City<span style="color: red;">*</span></span>
            <input type="text" name="City" placeholder="Enter your City" name="city" minlength="2" maxlength="30"
              required>
          </div>
          <div class="input-box">
            <span class="details">Age<span style="color: red;">*</span></span>
            <input type="text" name="Age" placeholder="Enter your age" name="age" required>
          </div>
          <div class="input-box">
            <span class="details">Language<span style="color: red;">*</span></span>
            <input type="text" name="Language" placeholder="Language you spoken" name="language" required>
          </div>
          <div class="input-box">
            <span class="details">Bio<span style="color: red;">*</span></span>
            <textarea rows="5" name="Bio" cols="40" name="bio" style="background-color: #222; color:white;"></textarea>

          </div>
          <div>
            <label for="file-input" class="input-file-label">Upload Photo </label><br>
            <input type="file" class="input-file" accept="image/*" id="file-input">

          </div>
        </div>
        <div class="gender-details">
          <input type="radio" name="gender" id="dot-1" checked required>
          <input type="radio" name="gender" id="dot-2" required>
          <span class="gender-title">Gender<span style="color: red;">*</span></span>
          <div class="category">
            <label for="dot-1">
              <span class="dot one"></span>
              <span class="gender">Male</span>
            </label>
            <label for="dot-2">
              <span class="dot two"></span>
              <span class="gender">Female</span>
            </label>
          </div>
        </div>
        <div class="button">
          <input type="submit" value="Sign Up"> <!-- must add a login link-->
        </div>
        <div class="form-link">
          <button class="reviews-button"><a href="http://localhost/web/signinPartner.php"
              class="link login-link">Login</a></button>
        </div>
      </form>
    </div>
  </div>
  <script>
    const forms = document.querySelector(".forms"),
      pwShowHide = document.querySelectorAll(".eye-icon"),
      links = document.querySelectorAll(".link");

    pwShowHide.forEach(eyeIcon => {
      eyeIcon.addEventListener("click", () => {
        let pwFields = eyeIcon.parentElement.parentElement.querySelectorAll(".password");

        pwFields.forEach(password => {
          if (password.type === "password") {
            password.type = "text";
            eyeIcon.classList.replace("bx-hide", "bx-show");
            return;
          }
          password.type = "password";
          eyeIcon.classList.replace("bx-show", "bx-hide");
        })

      })
    })

    links.forEach(link => {
      link.addEventListener("click", e => {
        e.preventDefault(); //preventing form submit
        forms.classList.toggle("show-signup");
      })
    })
  </script>

</body>

</html>