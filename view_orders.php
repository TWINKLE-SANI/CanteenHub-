<?php
include 'database.php';
$db = new Database();
$conn = $db->getConnection();

$sql = "SELECT o.order_id, u.firstname, m.item_name, m.price, o.pickup_time, o.payment_status
        FROM orders o
        JOIN users u ON o.user_id = u.slno
        JOIN menu m ON o.menu_id = m.menu_id
        ORDER BY o.pickup_time ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Orders - Smart Canteen</title>
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
            max-width: 1100px;
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

        tr:hover {
            background-color: #222;
        }

        select {
            padding: 6px 10px;
            border-radius: 5px;
            background-color: #111;
            color: white;
            border: 1px solid #444;
        }

        button {
            padding: 6px 12px;
            background-color: #ff5733;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }

        button:hover {
            background-color: #e64a19;
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
    <h2>Orders (Soonest Pickup First)</h2>
    <table>
        <tr>
            <th>User</th>
            <th>Item</th>
            <th>Price</th>
            <th>Pickup Time</th>
            <th>Payment Status</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<form method="POST" action="handle_payment_status.php">';
                echo "<tr>
                        <td>" . htmlspecialchars($row['firstname']) . "</td>
                        <td>" . htmlspecialchars($row['item_name']) . "</td>
                        <td>₹" . htmlspecialchars($row['price']) . "</td>
                        <td>" . htmlspecialchars($row['pickup_time']) . "</td>
                        <td>
                            <select name='payment_status'>
                                <option value='not paid'" . ($row['payment_status'] == 'not paid' ? ' selected' : '') . ">Not Paid</option>
                                <option value='paid'" . ($row['payment_status'] == 'paid' ? ' selected' : '') . ">Paid</option>
                            </select>
                        </td>
                        <td>
                            <input type='hidden' name='order_id' value='" . $row['order_id'] . "'>
                            <button type='submit'>Update</button>
                        </td>
                      </tr>";
                echo '</form>';
            }
        } else {
            echo "<tr><td colspan='6'>No orders yet.</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
