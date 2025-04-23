<?php
include 'db_connection.php';
header("Content-Type: application/json");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['user_id'], $data['product_id'], $data['quantity'])) {
    echo json_encode(["error" => "Missing required fields"]);
    exit;
}

$user_id = $data['user_id'];
$product_id = $data['product_id'];
$quantity = $data['quantity'];

// Step 1: Check if user exists
$check_user = $conn->prepare("SELECT user_id FROM user_profiles WHERE user_id = ?");
$check_user->bind_param("i", $user_id);
$check_user->execute();
$check_user->store_result();

if ($check_user->num_rows === 0) {
    echo json_encode(["error" => "User does not exist"]);
    exit;
}
$check_user->close();

$check_product = $conn->prepare("SELECT product_name, price, quantity_available FROM products WHERE product_id = ?");
$check_product->bind_param("i", $product_id);
$check_product->execute();
$result = $check_product->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["error" => "Product not found"]);
    exit;
}

$product = $result->fetch_assoc();
$product_name = $product['product_name'];
$price = $product['price'];
$available_quantity = $product['quantity_available'];

if ($quantity > $available_quantity) {
    echo json_encode(["error" => "Not enough stock available"]);
    exit;
}
$check_product->close();

$stmt = $conn->prepare("INSERT INTO user_cart (user_id, product_id, product_name, price, quantity) 
                        VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iisdi", $user_id, $product_id, $product_name, $price, $quantity);

if ($stmt->execute()) {
    echo json_encode(["message" => "Item added to cart successfully"]);
} else {
    echo json_encode(["error" => $stmt->error]);
}
$stmt->close();
$conn->close();
?>
