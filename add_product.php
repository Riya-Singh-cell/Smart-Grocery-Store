<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "ssg"; // change if your database name is different

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Check if required fields are set
if (isset($data["product_id"]) && isset($data["product_name"]) && isset($data["price"]) && isset($data["quantity_available"])) {
    $product_id = $data["product_id"];
    $product_name = $data["product_name"];
    $price = $data["price"];
    $quantity = $data["quantity_available"];

    $sql = "INSERT INTO products (product_id, product_name, price, quantity_available)
            VALUES ('$product_id', '$product_name', '$price', '$quantity')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Product added successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Missing one or more fields."]);
}

$conn->close();
?>
