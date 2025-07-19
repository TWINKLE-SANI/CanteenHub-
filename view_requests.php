<?php
include 'database.php';
$db = new Database();
$conn = $db->getConnection();

$sql = "SELECT r.request_id, u.firstname, m.item_name, m.price 
        FROM order_requests r
        JOIN users u ON r.user_id = u.slno
        JOIN menu m ON r.menu_id = m.menu_id
        WHERE r.status = 'pending'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Requests - Smart Canteen</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Monoton&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #000;
            margin: 0;
            padding: 0;
            color: #fff;
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
            padding: 15px 30px;
            text-decoration: none;
            color: #ff5733;
            font-weight: 600;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        nav a:hover {
            background-color: #1a1a1a;
        }

        .container {
            margin: 40px auto;
            width: 90%;
            max-width: 1000px;
            background-color: #1a1a1a;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(255, 87, 51, 0.3);
        }

        h2 {
            text-align: center;
            color: #ff5733;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #000;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #444;
        }

        th {
            background-color: #111;
            color: #ff5733;
        }

        input[type="time"] {
            padding: 5px 10px;
            border-radius: 6px;
            border: none;
            background-color: #222;
            color: #fff;
        }

        button {
            padding: 8px 12px;
            margin: 4px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[name="action"][value="accept"] {
            background-color: #28a745;
            color: white;
        }

        button[name="action"][value="accept"]:hover {
            background-color: #218838;
        }

        button[name="action"][value="reject"] {
            background-color: #dc3545;
            color: white;
        }

        button[name="action"][value="reject"]:hover {
            background-color: #c82333;
        }

        form {
            margin: 0;
        }
    </style>
</head>
<body>

<header>Canteen Hub+</header>

<nav>
    <a href="owner_homePage.php">Set Availability</a>
    <a href="add_item.php">Add New Item</a>
    <a href="view_requests.php">View Order Request</a>
    <a href="view_orders.php">View Orders</a>
    <a href="view_payments.php">View Payments</a>
</nav>

<div class="container">
    <h2>Incoming Order Requests</h2>
    <table>
        <tr>
            <th>User</th>
            <th>Item</th>
            <th>Price</th>
            <th>Pickup Time</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <form method="POST" action="handle_order.php">
                <tr>
                    <td><?= htmlspecialchars($row['firstname']) ?></td>
                    <td><?= htmlspecialchars($row['item_name']) ?></td>
                    <td>₹<?= htmlspecialchars($row['price']) ?></td>
                    <td><input type="time" name="pickup_time" required></td>
                    <td>
                        <input type="hidden" name="request_id" value="<?= $row['request_id'] ?>">
                        <button type="submit" name="action" value="accept">Accept</button>
                        <button type="submit" name="action" value="reject">Reject</button>
                    </td>
                </tr>
            </form>
        <?php } ?>
    </table>
</div>

</body>
</html>
