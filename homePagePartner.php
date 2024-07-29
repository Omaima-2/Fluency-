<?php
session_start();
include ("connect.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home Page</title>
  <link rel="stylesheet" href="stylesHomepage.css" />

  <link rel="icon" href="Logo.png" type="image/x.icon">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css"
    integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous" />
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
          <a href="#home" class="navbar__links" id="home-page">Home</a>
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
              <li><a href="ProfilePartner.php">View profile</a></li>
              <li> <a href="#overlay" class="open-button">delete account</a></li>
              <div class="overlay" id="overlay">
                <div class="message">
                  <h2>Are you sure?</h2>
                  <p>You want to delete account</p>

                  <div>
                    <form style="display: inline;" method="post">
                      <button type="submit" name="but" style="background-color: red;">Yes</button>
                    </form>
                    <form action="homePagePartner.html" style="display: inline;">
                      <button type="submit" style="background-color: green;">No</button>
                    </form>

                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                      // Check if the user is logged in
                      if (isset($_POST['but'])) {
                        // Assuming you have established the database connection earlier in your code
                    
                        // Delete the account
                        $user_id = $_SESSION['partner_id'];
                        $deleteQuery = "DELETE FROM partner_info WHERE partner_id = $user_id";
                        $deleteResult = mysqli_query($conn, $deleteQuery);

                        if ($deleteResult) {
                          // Account deletion successful
                          echo "<script>alert('delete done')</script>";
                          header("Location:fluency.html");
                          session_destroy(); // Destroy the session after deleting the account
                          exit;
                        } else {
                          // Account deletion failed
                          echo "Error deleting account: " . mysqli_error($conn);
                        }
                      }
                    }
                    ?>
                  </div>
                </div>
              </div>
              <li><a href="fluency.html">Sign out</a></li>
            </ul>
          </div>
        </li>
        <img src="ProfileIcon.png" alt="Profile" class="custom-img">

      </ul>
    </div>
  </nav>

  <!-- Services Section -->
  <div class="services" id="services">
    <h1>Services</h1>
    <div class="services__wrapper">
      <div class="services__card">
        <h2>Language learning requests</h2>
        <p>Start tutoring</p>
        <div class="services__btn"><button><a href="listOfRequset.php">Pending requests</a></button></div>
        <div class="services__btn"><button><a href="CardStatue1.php">Accepted/Rejected requests</a></button></div>
      </div>
      <div class="services__card">
        <h2>View my current sessions</h2>
        <p>Be ready</p>
        <div class="services__btn"><button><a href="currentSessionPartner.php">Let's view</a></button></div>
      </div>
      <div class="services__card">
        <h2>My reviews and ratings</h2>
        <p>Keep improving your self</p>
        <div class="services__btn"><button><a href="raitingAndReviewPartner.php">Let's view</a></button></div>
      </div>
    </div>
  </div>


  <!-- Footer Section -->
  <div class="footer__container">
    <div class="footer__links">
      <div class="footer__link--wrapper">
        <div class="footer__link--items">
          <h2>About Us</h2>
          <a href="/sign__up">How it works</a> <a href="/">Testimonials</a>
          <a href="/">Careers</a> <a href="/">Terms of Service</a>
        </div>
        <div class="footer__link--items">
          <h2>Contact Us</h2>
          <a href="/">Contact</a> <a href="/">Support</a>
          <a href="/">Destinations</a>
        </div>
      </div>
      <div class="footer__link--wrapper">
        <div class="footer__link--items">
          <h2>Videos</h2>
          <a href="/">Submit Video</a> <a href="/">Ambassadors</a>
          <a href="/">Agency</a>
        </div>
        <div class="footer__link--items">
          <h2>Social Media</h2>
          <a href="/">Instagram</a> <a href="/">Facebook</a>
          <a href="/">Youtube</a> <a href="/">Twitter</a>
        </div>
      </div>
    </div>
    <section class="social__media">
      <div class="social__media--wrap">
        <div class="footer__logo">
          <a href="/" id="footer__logo">COLOR</a>
        </div>
        <p class="website__rights">© COLOR 2020. All rights reserved</p>
        <div class="social__icons">
          <a href="/" class="social__icon--link" target="_blank"><i class="fab fa-facebook"></i></a>
          <a href="/" class="social__icon--link"><i class="fab fa-instagram"></i></a>
          <a href="/" class="social__icon--link"><i class="fab fa-youtube"></i></a>
          <a href="/" class="social__icon--link"><i class="fab fa-linkedin"></i></a>
          <a href="/" class="social__icon--link"><i class="fab fa-twitter"></i></a>
        </div>
      </div>
    </section>
  </div>

</body>

</html>