<?php
include 'db.php';

// array of the days of the week
$days = ["monday", "tuesday", "wednesday", "thursday", "friday"];

function is_correct_time_format($time) {
    return preg_match("/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/", $time);
}

function is_valid_time($time) {
    // must be between 09:00 and 15:30
    return strtotime($time) >= strtotime("09:00") && strtotime($time) <= strtotime("15:30");
}

function validate_inputs($subjectId, $day, $startTime, $endTime) {
    global $conn;
    global $days;

    $errors = [];

    // subjectName must be an option from SELECT `id` FROM `subject`;
    if (!in_array($subjectId, retrieveSubjectIds($conn))) {
        // form provides a name, not an id, so error message is 'name'
        $errors[] = "Subject name is not valid";
    }

    // day must be one of the following: Monday, Tuesday, Wednesday, Thursday, Friday
    if (!in_array($day, $days)) {
        $errors[] = "Day is not valid";
    }

    // startTime must be a valid time in the format HH:MM 
    if (!is_correct_time_format($startTime)) {
        $errors[] = "Start time is not valid";
    }

    // endTime must be a valid time in the format HH:MM
    if (!is_correct_time_format($endTime)) {
        $errors[] = "End time is not valid";
    }

    // startTime must be between 09:00 and 15:30
    if (!is_valid_time($startTime)) {
        $errors[] = "Start time must be between 09:00 and 15:30";
    }

    // endTime must be between 09:00 and 15:30
    if (!is_valid_time($endTime)) {
        $errors[] = "End time must be between 09:00 and 15:30";
    }

    // endTime must be after startTime
    if (strtotime($endTime) <= strtotime($startTime)) {
        $errors[] = "End time must be after start time";
    }

    return $errors;
}
?>