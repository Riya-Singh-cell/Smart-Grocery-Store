<?php
include __DIR__ . '/db.php';

header("Content-Type: application/json");

$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Check for required fields
if (!$data || !isset($data["user_id"], $data["total_amount"], $data["order_date"], $data["status"])) {
    echo json_encode([
        "status"  => "error",
        "message" => "Missing required fields",
        "raw_input" => $input
    ]);
    exit;
}

// Escape values
$user_id = $conn->real_escape_string($data["user_id"]);
$total_amount = $conn->real_escape_string($data["total_amount"]);
$order_date = $conn->real_escape_string($data["order_date"]);
$status = $conn->real_escape_string($data["status"]);

// Insert into orders table
$sql = "INSERT INTO orders (user_id, total_amount, order_date, status)
        VALUES ('$user_id', '$total_amount', '$order_date', '$status')";

if ($conn->query($sql)) {
    echo json_encode(["status" => "success", "message" => "Order added successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add order", "error" => $conn->error]);
}
?>
