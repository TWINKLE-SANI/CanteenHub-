<?php
include 'database.php';
$db = new Database();
$conn = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["order_id"], $_POST["payment_status"])) {
    $order_id = intval($_POST["order_id"]);
    $payment_status = $_POST["payment_status"];

    $sql = "UPDATE orders SET payment_status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $payment_status, $order_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: view_orders.php");
exit();
?>
