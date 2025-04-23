<?php
include 'db_connection.php';
header("Content-Type: application/json");

// Get the JSON body
$data = json_decode(file_get_contents("php://input"), true);

// Check if all fields are present
if (
    isset($data['order_id'], $data['user_id'], $data['order_date'],
          $data['amount'], $data['delivery_date'], $data['status'])
) {
    // Assign variables
    $order_id = $data['order_id'];
    $user_id = $data['user_id'];
    $order_date = $data['order_date'];
    $amount = $data['amount'];
    $delivery_date = $data['delivery_date'];
    $status = $data['status'];

    // Check if user_id exists in user_profiles
    $check_user = $conn->prepare("SELECT user_id FROM user_profiles WHERE user_id = ?");
    $check_user->bind_param("i", $user_id);
    $check_user->execute();
    $check_user->store_result();

    if ($check_user->num_rows > 0) {
        // User exists, proceed to insert order
        $stmt = $conn->prepare("INSERT INTO orders (order_id, user_id, order_date, amount, delivery_date, status)
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisdss", $order_id, $user_id, $order_date, $amount, $delivery_date, $status);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Order placed successfully"]);
        } else {
            echo json_encode(["error" => $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["error" => "User ID does not exist. Please register user first."]);
    }

    $check_user->close();
} else {
    echo json_encode(["error" => "Missing required fields"]);
}

$conn->close();
?>
