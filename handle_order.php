<?php
include 'database.php';
$db = new Database();
$conn = $db->getConnection();

$request_id = $_POST['request_id'];
$action = $_POST['action'];

if ($action === 'accept') {
    $pickup_time = $_POST['pickup_time'];

    // Get data from order_requests
    $getSql = "SELECT user_id, menu_id FROM order_requests WHERE request_id = ?";
    $stmt = $conn->prepare($getSql);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $stmt->bind_result($user_id, $menu_id);
    $stmt->fetch();
    $stmt->close();

    // Insert into orders table
    $insertSql = "INSERT INTO orders (user_id, menu_id, pickup_time,request_id) VALUES (?, ?, ?,?)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("iisi", $user_id, $menu_id, $pickup_time,$request_id);
    $insertStmt->execute();
    $insertStmt->close();

    // Update status to 'accepted' in order_requests
    $updateSql = "UPDATE order_requests SET status = 'accepted' WHERE request_id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("i", $request_id);
    $updateStmt->execute();
    $updateStmt->close();

} elseif ($action === 'reject') {
    $deleteSql = "UPDATE order_requests SET status = 'rejected' WHERE request_id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: view_orders.php");
exit();
?>
