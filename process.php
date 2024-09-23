<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'validation.php';

// Get the form data
$subjectName = $_POST['subject-name'];
$day = $_POST['day'];
$startTime = $_POST['start-time'];
$endTime = $_POST['end-time'];

// convert subject name to id
$subjectId = findSubjectIdByName($conn, $subjectName);

$errors = validate_inputs($subjectId, $day, $startTime, $endTime);

if (empty($errors)) {
    $query = "INSERT INTO `class` (`subject_id`, `day`, `time_start`, `time_end`) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $subjectId, $day, $startTime, $endTime);

    if ($stmt->execute()) {
        $message = "Record inserted successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    // add "Error:" to each error message
    $errors = array_map(function($error) {
        return "Error: " . $error;
    }, $errors);
    // join the errors into a single string
    $message = implode("<br>", $errors);
}

// Close the connection to the database
$conn->close();

// Redirect back to the form with a message
header("Location: /mysql-form/?message=" . urlencode($message));
exit();
?>