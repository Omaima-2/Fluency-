<?php
session_start(); // Start the session
include 'connect.php';

// Check if the user is logged in
if (isset($_SESSION['learner_id'])) {
  // User is logged in, retrieve the user ID
  $learner_id = $_SESSION['learner_id'];
}


?>

<!DOCTYPE html>
<!-- Created By CodingLab - www.codinglabweb.com -->
<html lang="en" dir="ltr">

<head>
  <title> Post Request </title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="postStyle.css" />

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
            <li><a href="fluency.html">Sign out</a></li>

          </ul>
        </div>
      </li>
      <img src="ProfileIcon.png" alt="Profile" class="custom-img">
    </ul>
  </nav>
  <div class="container">

    <div class="title" id="postreq">Post Request</div>
    <div class="content">
      <form method="POST">
        <div class="user-details">
          <div class="input-box">
            <label class="details">Level:</label>
            <select name="Level" required>
              <option value="" disabled selected>your current level</option>
              <option value="Beginner">Beginner</option>
              <option value="intermediate">Intermediate</option>
              <option value="advanced">Advanced</option>
              <!-- Add more options for other levels as needed -->
            </select>
          </div>

          <div class="input-box">
            <label class="details" for="date-input">Select Date:</label><br>
            <input name="date" type="date" id="date-input" required>

            <script>
              // Get today's date
              var today = new Date();

              // Format the date to YYYY-MM-DD
              var dd = String(today.getDate()).padStart(2, '0');
              var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
              var yyyy = today.getFullYear();

              today = yyyy + '-' + mm + '-' + dd;

              // Set the min attribute of the input element
              document.getElementById("date-input").setAttribute("min", today);
            </script>
          </div>

          <div class="input-box">
            <label class="details" for="duration-input">Select Duration (in minutes):</label>
            <input name="Duration" type="number" id="duration-input" min="15" step="15" max="45" value="30" required>
          </div>

          <div class="input-box">
            <label class="details" for="time-slot">Select Time Slot:</label>
            <select name="time" id="time-slot" required></select>
          </div>
          <script>
            // Function to generate time slots based on duration
            function generateTimeSlots(duration, selectedDate) {
              var startTime = new Date(selectedDate); // Get selected date
              var endTime = new Date(selectedDate);
              var currentDate = new Date();

              // Check if the selected date is the current date
              if (startTime.toDateString() !== currentDate.toDateString()) {
                // If it's not the current date, set startTime to beginning of the day
                startTime.setHours(0, 0, 0);
                // Set endTime to end of the day (11:59:59 PM)
                endTime.setHours(23, 59, 59);
              } else {
                // If it's the current date, set startTime to current time
                startTime = currentDate;
                endTime.setHours(23, 59, 59); // Set end time to end of the day
              }

              var timeSlots = [];

              while (startTime < endTime) {
                var slotEndTime = new Date(startTime.getTime() + duration * 60000); // Add duration to start time
                timeSlots.push({
                  start: startTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                });
                startTime = slotEndTime; // Move start time to the end of the current slot
              }

              return timeSlots;
            }

            // Function to populate select options with time slots
            function populateTimeSlots(duration, selectedDate) {
              var timeSlotSelect = document.getElementById("time-slot");
              timeSlotSelect.innerHTML = ''; // Clear existing options

              var timeSlots = generateTimeSlots(duration, selectedDate);

              timeSlots.forEach(function (slot) {
                var option = document.createElement("option");
                option.text = slot.start;
                timeSlotSelect.add(option);
              });
            }

            // Function to handle date input change
            document.getElementById("date-input").addEventListener("change", function () {
              var selectedDate = this.value;
              var duration = parseInt(document.getElementById("duration-input").value, 10);
              populateTimeSlots(duration, selectedDate);
            });

            // Function to handle duration input change
            document.getElementById("duration-input").addEventListener("input", function () {
              var duration = parseInt(this.value, 10);
              var selectedDate = document.getElementById("date-input").value;
              populateTimeSlots(duration, selectedDate);
            });

            // Initial population of time slots
            var initialDuration = parseInt(document.getElementById("duration-input").value, 10);
            var initialDate = document.getElementById("date-input").value;
            populateTimeSlots(initialDuration, initialDate);
          </script>
          <div>
            <input type="submit" value="Post" class="green-button">
            <input type="reset" value="Clear" class="red-button" formaction="postRequest.php">
          </div>
        </div>
      </form>
    </div>
  </div>
  <?php
  if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Retrieve form data
    $partnerID = intval($_GET['partnerId']); // Change $_GET to $_POST to retrieve partnerId from form
    $level = $_POST['Level'];
    $selectedDate = $_POST['date'];
    $time = $_POST['time'];
    $duration = intval($_POST['Duration']); // Convert duration to integer
  
    // Check if the same data already exists
    $query = "SELECT COUNT(*) FROM requestsessions1 WHERE pID_req = $partnerID AND LID_req = $learner_id AND Level = '$level' AND Date = '$selectedDate' AND time = '$time'";
    $result = mysqli_query($conn, $query);

    if ($result) {
      $row = mysqli_fetch_row($result);
      $count = $row[0];

      if ($count > 0) {
        // Same data already exists, display a message
        echo "<script>alert('The same data has already been submitted.')</script>";
      } else {
        // Data does not exist, proceed with insertion
        $insertQuery = "INSERT INTO requestsessions1 (pID_req, LID_req, Level, Date, time, Duration) VALUES ($partnerID, $learner_id, '$level', '$selectedDate', '$time', $duration)";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
          // Insertion successful
          echo "<script>alert('Data inserted successfully.')</script>";
          // Optionally, redirect to the success page or any other desired page
        } else {
          // Insertion failed
          $message = "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
        }
      }
    } else {
      // Error in executing the query
      $message = "Error: " . $query . "<br>" . mysqli_error($conn);
    }
   // header("location:http://localhost/web/homePageLearner.php");

  }
  ?>
</body>

</html>