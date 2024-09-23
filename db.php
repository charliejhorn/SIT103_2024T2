<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sit103-9.2d";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function retrieveSubjectNames($conn) {
    $query = "SELECT `name` FROM `subject`";
    $result = $conn->query($query);
    $subjectNames = [];
    while($row = $result->fetch_assoc()) {
        $subjectNames[] = $row['name'];
    }
    return $subjectNames;
}

function retrieveSubjectIds($conn) {
    $query = "SELECT `id` FROM `subject`";
    $result = $conn->query($query);
    $subjectIds = [];
    while($row = $result->fetch_assoc()) {
        $subjectIds[] = $row['id'];
    }
    return $subjectIds;
}

function findSubjectIdByName($conn, $subjectName) {
    $query = "SELECT `id` FROM `subject` WHERE `name` = '$subjectName'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['id'];
}
?>