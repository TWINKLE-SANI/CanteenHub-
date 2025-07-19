<?php
include 'database.php';
$db = new Database();
$conn = $db->getConnection();

// Step 3: Handle form submission to mark all unpaid orders for a user as paid
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $update_sql = "UPDATE orders SET payment_status = 'paid' WHERE user_id = ? AND payment_status = 'not paid'";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
}

// Step 1: Get total unpaid amount per user
$sql = "SELECT u.slno AS user_id, u.firstname, SUM(m.price) AS total_due
        FROM orders o
        JOIN users u ON o.user_id = u.slno
        JOIN menu m ON o.menu_id = m.menu_id
        WHERE o.payment_status = 'not paid'
        GROUP BY u.slno, u.firstname";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Payments</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Monoton&family=Poppins&display=swap');

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
  <h2>Pending Payments per User</h2>

  <table>
    <tr>
      <th>User</th>
      <th>Total Due</th>
      <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
      <tr>
        <td><?= htmlspecialchars($row['firstname']) ?></td>
        <td>₹<?= $row['total_due'] ?></td>
        <td>
          <form method="post">
            <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
            <button type="submit">Mark as Paid</button>
          </form>
        </td>
      </tr>
    <?php } ?>
  </table>
</div>

</body>
</html>
