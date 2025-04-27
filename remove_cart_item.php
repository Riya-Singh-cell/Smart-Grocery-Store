<?php
include 'db.php';
header('Content-Type: application/json');
session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;

if (!$user_id || !$product_id) {
    echo json_encode(['error' => 'Missing required parameters']);
    exit;
}

$stmt = $conn->prepare('DELETE FROM user_cart WHERE user_id = ? AND product_id = ?');
$stmt->bind_param('ii', $user_id, $product_id);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => $stmt->error]);
}
$stmt->close();
$conn->close();
?>
