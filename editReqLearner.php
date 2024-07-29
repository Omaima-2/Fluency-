<?php
session_start(); // Start the session
include 'connect.php';


if (isset($_SESSION['learner_id'])) {
    // User is logged in, retrieve the user ID
    $learner_id = $_SESSION['learner_id'];

    $sql = "SELECT * FROM requestsessions1 WHERE Status=0 AND LID_req = $learner_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $Pid = $row['pID_req'];
            $Lid = $row['LID_req'];
            //$name = $row['Fname'];
            //$Lname = $row['Lname'];
            $duration = $row['Duration'];
            $Level = $row['Level'];
            $date = $row['Date'];
            //$email = $row['email'];
            $time = $row['time'];
            $status = $row['Status'];
            $card = $row['cardID'];

            // Process the data here, e.g., display it, store it in an array, etc.
            // You can also perform any necessary operations inside this loop
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "User is not logged in."; // You may want to handle this case appropriately
}
?>



<!DOCTYPE html>
<!-- Created By CodingLab - www.codinglabweb.com -->
<html lang="en" dir="ltr">

<head>
    <title> Edit Request </title>
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
        <a href="RequestLearner.php">
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

        <div class="title" id="postreq">Edit Request</div>
        <div class="content">
            <form method="POST">
                <div class="user-details">
                    <div class="input-box">
                        <label class="details">Level:</label>
                        <select name="Level" required>
                            <option value="<?php echo $Level; ?>" selected><?php echo $Level; ?></option>
                            <option value="Beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                            <!-- Add more options for other levels as needed -->
                        </select>
                    </div>

                    <div class="input-box">
                        <label class="details" for="date-input">Select Date:</label><br>
                        <input name="date" type="date" value="<?php echo $date; ?>" id="date-input" required>

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
                        <input name="Duration" type="number" value="<?php echo $duration; ?>" id="duration-input"
                            min="15" step="15" max="45" required>
                    </div>

                    <div class="input-box">
                        <label class="details" for="time-slot">Select Time Slot:</label>
                        <select name="time" id="time-slot" required>
                            <option value="<?php echo $time; ?>" selected><?php echo $time; ?></option>
                        </select>
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
                        <input type="submit" value="Save" name="Edit" class="green-button">
                        <input type="submit" value="Cancle" name="can" class="red-button">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["Edit"])) {
            // Retrieve the updated values from the form inputs
            $duration = $_POST["Duration"];
            $Level = $_POST["Level"];
            $date = $_POST["date"];
            $time = $_POST["time"];

            // Perform the update query using the updated values
            $updateQuery = "UPDATE requestsessions1 SET Duration=$duration, Level='$Level', Date='$date', time='$time' WHERE cardID= $card";
            $result1 = mysqli_query($conn, $updateQuery);

            // Check if the query was successful
            if ($result1) {
                echo "<script>alert('request updated successfully')</script>";
                header("Location:http://localhost/web/RequestLearner.php");
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        } elseif (isset($_POST["can"])) {
            // Perform the delete query
            $deleteQuery = "DELETE FROM requestsessions1 WHERE cardID = $card";
            $result2 = mysqli_query($conn, $deleteQuery);

            // Check if the query was successful
            if ($result2) {
                echo "<script>alert('request delete successfully')</script>";
            } else {
                echo "Error deleting record: " . mysqli_error($conn);
            }
        }
    }
    ?>
</body>

</html>