<?php
session_start();
require_once "database.php";

$db = new Database();
$conn = $db->getConnection();

$result = $conn->query("SELECT * FROM menu ORDER BY item_category");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Smart Canteen - Menu</title>
    <!-- Fonts -->
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
            padding: 15px 40px;
            text-decoration: none;
            color: #ff5733;
            font-weight: 600;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        nav a:hover {
            background-color: #1a1a1a;
        }

        .menu-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 30px;
            gap: 25px;
        }

        .card {
            background-color: #1a1a1a;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(255, 87, 51, 0.2);
            width: 250px;
            overflow: hidden;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.03);
        }

        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .card-content {
            padding: 15px;
        }

        .card-title {
            font-size: 20px;
            font-weight: 600;
            color: #fff;
        }

        .card-category {
            color: #ccc;
            font-size: 14px;
            margin-top: 5px;
        }

        .price {
            color: #ff5733;
            font-size: 16px;
            margin: 10px 0;
        }

        .order-btn {
            padding: 10px;
            width: 100%;
            background-color: #ff5733;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .order-btn:hover {
            background-color: #e64a19;
        }

        .order-btn:disabled {
            background-color: #444;
            cursor: not-allowed;
            color: #bbb;
        }
    </style>
</head>
<body>

<header>Canteen Hub+</header>

<nav>
    <a href="user_homePage.php">Menu</a>
    <a href="user_orders.php">Orders</a>
</nav>

<div class="menu-section">
<?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $available = (int)$row["available_qty"];
        echo '
        <div class="card">
            <img src="' . htmlspecialchars($row["image_url"]) . '" alt="' . htmlspecialchars($row["item_name"]) . '">
            <div class="card-content">
                <div class="card-title">' . htmlspecialchars($row["item_name"]) . '</div>
                <div class="card-category">' . ucfirst(htmlspecialchars($row["item_category"])) . '</div>
                <div class="price">₹' . number_format($row["price"], 2) . '</div>';
        
        if ($available > 0) {
            echo '
                <form method="post" action="order_item.php">
                    <input type="hidden" name="menu_id" value="' . $row["menu_id"] . '">
                    <button class="order-btn" type="submit">Place Order</button>
                </form>';
        } else {
            echo '<button class="order-btn" type="button" disabled>Out of Stock</button>';
        }

        echo '
            </div>
        </div>';
    }
} else {
    echo "<p style='color:#fff;'>No menu items available.</p>";
}
?>
</div>

</body>
</html>
