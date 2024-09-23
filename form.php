<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

$subjectNames = retrieveSubjectNames($conn);
$days = ["monday", "tuesday", "wednesday", "thursday", "friday"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form</title>
</head>
<body>
    <h1>Create a new class</h1>
    <form action="process.php" method="POST">
        <!-- dropdown of all the subject names -->
        <label for="subject-name">Subject Name:</label>
        <select id="subject-name" name="subject-name" required>
            <option value="">Select a subject</option>
            <?php
            foreach ($subjectNames as $subjectName) {
                echo "<option value='$subjectName'>$subjectName</option>";
            }
            ?>
        </select><br>

        <!-- dropdown for the days of the week -->
        <label for="day">Day:</label>
        <select id="day" name="day" required>
            <option value="">Select a day</option>
            <?php
            foreach ($days as $day) {
                echo "<option value='$day'>$day</option>";
            }
            ?>
        </select><br>

        <!-- time input for the start time -->
        <label for="start-time">Start Time:</label>
        <input type="time" id="start-time" name="start-time" required><br>

        <!-- time input for the end time -->
        <label for="end-time">End Time:</label>
        <input type="time" id="end-time" name="end-time" required><br>

        <input type="submit" value="Submit">
    </form>

    <!-- Shows status message on submit -->
    <?php 
    if (isset($_GET['message'])): 
        $message = urldecode($_GET['message']); // get the message from the URL
        $message = nl2br($message); // Convert newlines to <br> tags
        $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); // Escape HTML special characters
        $message = str_replace('&lt;br&gt;', '<br>', $message); // Allow <br> tags to render correctly
    ?>
        <p id="status"><?php echo $message; ?></p> 
    <?php endif; ?>
</body>
</html>