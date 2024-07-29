<?php
session_start();
include ("connect.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the rating and review are set
    if (isset($_POST['rating']) && isset($_POST['review'])) {
        // Retrieve the rating and review from the form submission
        $rating = $_POST['rating'];
        $review = $_POST['review'];

        // Assuming you have retrieved the user ID from the session
        // If not, adjust this accordingly

        if (isset($_GET['pID'])) {// User is logged in, retrieve the user ID
            $parnter_id = $_GET['pID'];

            $user_id = $_SESSION['learner_id'];

            // Retrieve other necessary data (e.g., partner ID)
            // $partner_id = $_GET["partner_id"];

            // Prepare and execute the SQL statement to insert the rating and review into the database
            $query = "INSERT INTO partnerreviews1 (pID , LID , Comments, Stars) VALUES ($parnter_id,$user_id, '$review' , $rating)";
            $result = mysqli_query($conn, $query);


            // Check if the insertion was successful
            if ($result) {
                echo "<script>alert('Rating and review stored successfully.');</script>";
                header("Location:http://localhost/web/preSessionLearner.php");
            } else {
                echo "<script>alert('Error storing rating and review.');</script>";
            }
        } else {
            echo "<script>alert('User not logged in.');</script>";
        }
    } else {
        echo "<script>alert('Rating or review not provided.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="raitingAndReviwLearner.css">
    <link rel="icon" href="Logo.png" type="image/x.icon">
    <title>Rate Partner</title>
</head>

<body>
    <div class="backBtn">
        <a href="preSessionLearner.php">
            <span class="line tLine"></span>
            <span class="line mLine"></span>
            <span class="label">Back</span>
            <span class="line bLine"></span>
        </a>
    </div> <!-- Navbar Section -->






    <div class="container">
        <h1>How did you find your experience?</h1>
        <!-- Form for submitting review -->
        <form action="#" method="POST">
            <!-- Hidden input field for rating -->
            <label style="color: white;">Rate (out of 5): <input type="number" name="rating" min="1" max="5"
                    required></label>
            <!-- Name for the rating input field -->
            <p class="par">Share your review:</p>
            <!-- Textarea for review -->
            <textarea id="review" name="review" placeholder="Write your review here"></textarea>
            <!-- Submit button -->
            <button type="submit" id="submit">Submit</button>
        </form>
        <!-- Container for displaying reviews -->
        <div class="reviews" id="reviews">
        </div>
    </div>
    <!--<script src="script.js"></script>-->

</body>

</html>