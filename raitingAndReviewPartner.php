<?php
session_start();
include ("connect.php");

// Retrieve reviews and ratings for the partner
if (isset($_GET['partner_id'])) {
    $partner_id = $_GET['partner_id'];
    $sql = "SELECT * FROM partnerreviews1 WHERE pID = $partner_id";
    $result = mysqli_query($conn, $sql);
} else if (isset($_SESSION['partner_id'])) { // User is logged in, retrieve the user ID
    $partner_id = $_SESSION['partner_id'];
    $sql = "SELECT * FROM partnerreviews1 WHERE pID = $partner_id";
    $result = mysqli_query($conn, $sql);
}
if (!$result) {
    die("Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Reviews</title>
    <!--Stylesheet--------------------------->
    <link rel="stylesheet" href="ratingAndReviwPartner.css" />
    <link rel="icon" href="Logo.png" type="image/x.icon">
    <!--Fav-icon-->
    <link rel="shortcut icon" href="images/fav-icon.png" />
    <!--poppins-font-family-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!--using-Font-Awesome-->
    <script src="https://kit.fontawesome.com/c8e4d183c2.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Back button -->
    <div class="backBtn">
        <a href="homePagePartner.php">
            <span class="line tLine"></span>
            <span class="line mLine"></span>
            <span class="label">Back</span>
            <span class="line bLine"></span>
        </a>
    </div> <!-- Navbar Section -->
    <nav class="navbar">
        <div class="navbar__container">
            <img src="LogoBlackBackground.PNG" alt="Fluency">

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
                            <li><a href="ProfilePartner.php">View profile</a></li>

                            <li><a href="fluency.html">Sign out</a></li>
                        </ul>
                    </div>
                </li>
                <img src="ProfileIcon.png" alt="Profile" class="custom-img">
            </ul>
        </div>
    </nav>

    <!-------------------------------------------------------------------------------->

    <!-- Testimonials -->
    <section id="testimonials">
        <!-- Heading -->
        <div class="testimonial-heading">
            <br>
            <h1>Partner Reviews</h1>
        </div>
        <!-- Testimonials box container -->
        <div class="testimonial-box-container">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <!-- Testimonial box -->
                    <div class="testimonial-box">
                        <!-- Top -->
                        <div class="box-top">
                            <!-- Profile -->
                            <div class="profile">
                                <!-- Image -->
                                <div class="profile-img">
                                    <img src="images/userpic.png" alt="user picture">
                                </div>
                                <!-- Name and username -->
                                <div class="name-user">
                                    <strong><?php echo $row["LID"]; ?></strong>
                                    <span>@<?php echo $row["pID"]; ?></span>
                                </div>
                            </div>
                            <!-- Reviews -->
                            <div class="reviews">
                                <!-- Show stars based on rating -->
                                <?php
                                $rating = $row["Stars"];
                                for ($i = 0; $i < 5; $i++) {
                                    if ($i < $rating) {
                                        echo '<i class="fas fa-star"></i>';
                                    } else {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <!-- Comments -->
                        <div class="client-comment">
                            <p><?php echo $row["Comments"]; ?></p>
                        </div>
                    </div>
                    <!-- End of testimonials -->
                    <?php
                }
            } else {
                echo "<p>No reviews yet.</p>";
            }
            ?>
        </div>
    </section>
</body>

</html>