<?php
include 'database.php';
$db = new Database();
$conn = $db->getConnection();

$request_id = $_GET['request_id'] ?? 0;

$response = ['status' => 'pending'];

// Step 1: Check if the order request exists
$sql = "SELECT status FROM order_requests WHERE request_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $request_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $status = $row['status'];

    if ($status === 'accepted') {
        // Check the orders table for pickup time
        $orderSql = "SELECT pickup_time FROM orders WHERE request_id = ?";
        $orderStmt = $conn->prepare($orderSql);
        $orderStmt->bind_param("i", $request_id);
        $orderStmt->execute();
        $orderResult = $orderStmt->get_result();

        if ($orderResult->num_rows > 0) {
            $orderData = $orderResult->fetch_assoc();
            $response['status'] = 'accepted';
            $response['pickup_time'] = $orderData['pickup_time'];
        }
        $orderStmt->close();
    } elseif ($status === 'rejected') {
        $response['status'] = 'rejected';
    }
} else {
    // Optional: you could say rejected if the request_id is gone
    $response['status'] = 'rejected';
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
