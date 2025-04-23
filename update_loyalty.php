<?php
include __DIR__ . '/db.php';

header("Content-Type: application/json");

// Read JSON input
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Validate input
if (!isset($data["user_id"], $data["points"])) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing user_id or points"
    ]);
    exit;
}

$user_id = intval($data["user_id"]);
$pointsToAdd = intval($data["points"]);

// Check if record exists
$check = $conn->query("SELECT * FROM loyalty_points WHERE user_id = $user_id");

if ($check->num_rows > 0) {
    // Update existing points
    $conn->query("UPDATE loyalty_points SET points = points + $pointsToAdd WHERE user_id = $user_id");
} else {
    // Insert new record
    $conn->query("INSERT INTO loyalty_points (user_id, points) VALUES ($user_id, $pointsToAdd)");
}

// Send success response
echo json_encode([
    "status" => "success",
    "message" => "Loyalty points updated"
]);
?>
