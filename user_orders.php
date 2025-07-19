<?php
session_start();
require_once "database.php";

$db = new Database();
$conn = $db->getConnection();

$user_id = $_SESSION['slno']; 

$query = "
    SELECT o.*, m.item_name, m.price 
    FROM orders o
    JOIN menu m ON o.menu_id = m.menu_id
    WHERE o.user_id = ?
    ORDER BY o.order_time DESC
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Smart Canteen - My Orders</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Monoton&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #000;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        header {
            font-family: 'Monoton', cursive;
            background-color: #000;
            color: #ff5733;
            padding: 20px;
            text-align: center;
            font-size: 36px;
            letter-spacing: 2px;
        }

        nav {
            display: flex;
            justify-content: center;
            background-color: #111;
            box-shadow: 0 4px 8px rgba(255, 87, 51, 0.3);
        }

        nav a {
            padding: 15px 40px;
            text-decoration: none;
            color: #ff5733;
            font-weight: 600;
            font-size: 18px;
        }

        nav a:hover {
            background-color: #1a1a1a;
        }

        h2 {
            text-align: center;
            margin: 30px;
            color: #ff5733;
        }

        table {
            width: 90%;
            margin: 0 auto 40px auto;
            border-collapse: collapse;
            background-color: #1a1a1a;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: center;
        }

        th {
            background-color: #ff5733;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #222;
        }

        tr:nth-child(odd) {
            background-color: #111;
        }

        .status-paid {
            color: lightgreen;
            font-weight: bold;
        }

        .status-not-paid {
            color: #f33;
            font-weight: bold;
        }
    </style>
</head>
<body>

<header>Canteen Hub+</header>

<nav>
    <a href="user_homePage.php">Menu</a>
    <a href="user_orders.php">Orders</a>
</nav>

<h2>My Orders</h2>

<?php if ($result && $result->num_rows > 0): ?>
    <table>
        <tr>
            <th>Item</th>
            <th>Price</th>
            <th>Order Time</th>
            <th>Pickup Time</th>
            <th>Payment</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['item_name']) ?></td>
                <td>₹<?= number_format($row['price'], 2) ?></td>
                <td><?= date("d-m-Y H:i", strtotime($row['order_time'])) ?></td>
                <td><?= htmlspecialchars($row['pickup_time']) ?></td>
                <td class="<?= $row['payment_status'] == 'paid' ? 'status-paid' : 'status-not-paid' ?>">
                    <?= ucfirst($row['payment_status']) ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p style="text-align: center;">You have no orders yet.</p>
<?php endif; ?>

</body>
</html>
