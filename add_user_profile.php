<?php
include 'db_connection.php';

header("Content-Type: application/json");

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Validate and assign variables
$user_id = $data['user_id'];
$user_name = $data['user_name'];
$email_id = $data['email_id'];
$mobile_number = $data['mobile_number'];
$location = $data['location'];

// Insert into the database
$sql = "INSERT INTO user_profiles (user_id, user_name, email_id, mobile_number, location) 
        VALUES ('$user_id', '$user_name', '$email_id', '$mobile_number', '$location')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["message" => "User profile added successfully"]);
} else {
    echo json_encode(["error" => $conn->error]);
}

$conn->close();
?>
