<?php
$servername = "localhost";
$username = "root"; // change if needed
$password = "";     // change if needed
$database = "ssg"; // your DB name

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
