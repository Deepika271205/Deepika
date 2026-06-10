<?php
header("Content-Type: application/json");

// Database connection
$conn = new mysqli("localhost", "root", "", "oven_craft");
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

// Read JSON input from fetch()
$data = json_decode(file_get_contents("php://input"), true);

// Validate minimal required fields
if (
    !isset($data['name'], $data['phone'], $data['address'], $data['payment'], $data['cart'], $data['total'])
) {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    exit;
}

// Safe defaults
$name = trim($data['name']);
$phone = trim($data['phone']);
$address = trim($data['address']);
$instructions = $data['instructions'] ?? "";  // optional
$payment = trim($data['payment']);
$cart_json = json_encode($data['cart']);
$total = floatval($data['total']);

// Prepare SQL
$stmt = $conn->prepare("
    INSERT INTO orders (customer_name, phone_number, address, instructions, payment_method, cart_items, total_amount)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param("ssssssd", $name, $phone, $address, $instructions, $payment, $cart_json, $total);

// Execute and respond
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "order_id" => $stmt->insert_id]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
