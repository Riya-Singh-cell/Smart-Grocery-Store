<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "ssg";

// Connect to database
$conn = new mysqli($host, $user, $password, $db);

// Set header to JSON
header("Content-Type: application/json");

// Get the raw input and decode JSON
$data = json_decode(file_get_contents("php://input"), true);

// Validate input
if (isset($data["user_id"]) && isset($data["points"])) {
    $user_id = $data["user_id"];
    $points = $data["points"];

    // Insert into loyalty_points
    $sql = "INSERT INTO loyalty_points (user_id, points, last_updated) 
            VALUES ('$user_id', '$points', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Loyalty points added successfully"]);
    } else {
        echo json_encode(["error" => $conn->error]);
    }

} else {
    echo json_encode(["error" => "Missing 'user_id' or 'points'"]);
}

$conn->close();
?>
