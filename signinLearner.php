<?php
session_start();
include ("connect.php");

if (isset($_SESSION['learner_id'])) {
    $learnerID = $_SESSION['learner_id'];

}
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $email = $_POST['uEmail'];
    $password = $_POST['uPassword'];

    $query = "select * from lerner_info where email= '$email' limit 1";
    $result = mysqli_query($conn, $query);
    if ($result) {
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            if ($user_data['password'] == $password) {
                $_SESSION['learner_id'] = $user_data['lerner_id'];
                header("location: homePageLearner.php");
            }
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="Logo.png" type="image/x.icon">

    <!-- CSS -->
    <link rel="stylesheet" href="signup_learner.css">

    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <section class="container forms">
        <div class="form login">
            <div class="form-content">
                <header>Login</header>
                <form method="POST">
                    <div class="field input-field">
                        <input name="uEmail" type="email" placeholder="Email" class="input" minlength="11"
                            maxlength="30" required>
                    </div>

                    <div class="field input-field">
                        <input name="uPassword" type="password" placeholder="Password" class="password" minlength="10"
                            maxlength="12" required>
                        <i class='bx bx-hide eye-icon'></i>
                    </div>

                    <div class="field button-field">
                        <button>Login</button>
                    </div>
                </form>

                <div class="form-link">
                    <button class="reviews-button"><a href="http://localhost/web/signup_learner.php">sign
                            up</a></button>
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