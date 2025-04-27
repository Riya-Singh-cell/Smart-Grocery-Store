<?php
include 'db.php';
header('Content-Type: application/json');
session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : null;

if (!$user_id || !$product_id || $quantity === null) {
    echo json_encode(['error' => 'Missing required parameters']);
    exit;
}

if ($quantity <= 0) {
    $stmt = $conn->prepare('DELETE FROM user_cart WHERE user_id = ? AND product_id = ?');
    $stmt->bind_param('ii', $user_id, $product_id);
    $stmt->execute();
    $stmt->close();
    echo json_encode(['success' => true, 'message' => 'Item removed']);
    $conn->close();
    exit;
}

$stmt = $conn->prepare('UPDATE user_cart SET quantity = ? WHERE user_id = ? AND product_id = ?');
$stmt->bind_param('iii', $quantity, $user_id, $product_id);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => $stmt->error]);
}
$stmt->close();
$conn->close();
?>
