<?php
session_start();
include 'database.php';
$db = new Database();
$conn = $db->getConnection();

$user_id = $_SESSION['slno'];
$menu_id = $_POST['menu_id'];

$sql = "INSERT INTO order_requests (user_id, menu_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $menu_id);

if ($stmt->execute()) {
    $request_id = $stmt->insert_id;
    header("Location: order_status.php?request_id=" . $request_id);
    exit();
} else {
    echo "Error placing order.";
}
?>
