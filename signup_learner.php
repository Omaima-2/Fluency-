<?php
session_start();
include ("connect.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $Fname = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $city = $_POST['city'];
    $location = $_POST['location'];

    $sql = "SELECT email FROM lerner_info WHERE email =  $email";
    $result = mysqli_query($conn, $sql);
    if ($resu = mysqli_fetch_assoc($result)) {
        echo "Email already exists in the database.";
    } else {
        $query = "insert into lerner_info(Fname,Lname,email,password,location,city) values ('$Fname','$lastName','$email','$password','$city','$location')";
        if (mysqli_query($conn, $query)) {
            // Insertion successful, retrieve the auto-generated learner ID
            $learnerID = mysqli_insert_id($conn);

            // Save the learner ID into the session
            $_SESSION['learner_id'] = $learnerID;

            // Redirect to the home page
            header("location: homePageLearner.php");
        } else {
            // Insertion failed
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
            // Optionally, redirect back to the form page or display an error message
        }
    }
}/// لا ننسى نحط عدم الدخول
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="icon" href="Logo.png" type="image/x.icon">

    <!-- CSS -->
    <link rel="stylesheet" href="signup_learner.css">

    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>


    <section class="container forms">
        <div class="form signup">
            <div class="form-content">
                <header>Signup</header>
                <form method="POST">
                    <span class="details" style="color: aliceblue;">First name<span style="color: red">*</span></span>
                    <div class="field input-field">
                        <input type="text" name="firstName" placeholder="Enter your First name" class="input"
                            minlength="2" maxlength="10" required>
                        <span class="errspan"></span>
                    </div>
                    <span class="details" style="color: aliceblue;">Last name<span style="color: red">*</span></span>
                    <div class="field input-field">
                        <input type="text" name="lastName" placeholder="Enter your Last name" class="input"
                            minlength="3" maxlength="20" required>
                        <span class="errspan"></span>
                    </div>
                    <span class="details" style="color: aliceblue;">Enter your Email<span
                            style="color: red">*</span></span>
                    <div class="field input-field">
                        <input type="email" name="email" placeholder="Email" class="input" minlength="11" maxlength="30"
                            required>
                        <span class="errspan"></span>
                    </div>
                    <span class="details" style="color: aliceblue;">Create password<span
                            style="color: red">*</span></span>
                    <div class="field input-field">
                        <input type="password" name="password" placeholder="Enter your password" class="password"
                            minlength="10" maxlength="30" required>
                        <i class='bx bx-hide eye-icon'></i>
                        <span class="errspan"></span>
                    </div>
                    <span class="details" style="color: aliceblue;">City<span style="color: red">*</span></span>
                    <div class="field input-field">
                        <input type="text" name="city" placeholder="Enter your City" class="input" minlength="2"
                            maxlength="20" required>
                        <span class="errspan"></span>
                    </div>
                    <span class="details" style="color: aliceblue;">Enter your Location<span
                            style="color: red">*</span></span>
                    <div class="field input-field">
                        <input type="text" name="location" placeholder="Enter your Location(National Address)"
                            class="input" minlength="2" maxlength="30" required>
                        <span class="errspan"></span>
                    </div>

                    <div>
                        <label for="file-input" class="input-file-label">Upload Photo:</label>
                        <input type="file" name="photo" class="input-file" accept="image/*" id="file-input">
                        <span class="errspan"></span>
                    </div>

                    <div class="field button-field">
                        <button>Signup</button>
                    </div>
                </form>

                <div class="form-link">
                    <span>Already have an account? <a href="http://localhost/web/signinLearner.php"
                            class="link login-link">Login</a></span>
                </div>
            </div>

            <div class="line"></div>
        </div>
    </section>
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