<?php
session_start();
require_once "database.php";

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["menu_id"], $_POST["available_qty"])) {
    $menu_id = intval($_POST["menu_id"]);
    $available_qty = max(0, intval($_POST["available_qty"]));

    $stmt = $conn->prepare("UPDATE menu SET available_qty = ? WHERE menu_id = ?");
    $stmt->bind_param("ii", $available_qty, $menu_id);
    $stmt->execute();
    $stmt->close();
}

$result = $conn->query("SELECT * FROM menu ORDER BY item_category");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Owner - Smart Canteen</title>
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
            width: 270px;
            overflow: hidden;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.02);
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

        .edit-form input[type="number"] {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: none;
            margin-bottom: 10px;
        }

        .edit-form button {
            background-color: #ff5733;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .edit-form button:hover {
            background-color: #e64a19;
        }
    </style>
</head>
<body>

<header>Canteen Hub+</header>

<nav>
    <a href="owner_homePage">Set Availability</a>
    <a href="add_item.php">Add New Item</a>
    <a href="view_requests.php">View Order Request</a>
    <a href="view_orders.php">View Orders</a>
    <a href="view_payments.php">View Payments</a>
</nav>

<div class="menu-section">
<?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '
        <div class="card">
            <img src="' . htmlspecialchars($row["image_url"]) . '" alt="' . htmlspecialchars($row["item_name"]) . '">
            <div class="card-content">
                <div class="card-title">' . htmlspecialchars($row["item_name"]) . '</div>
                <div class="card-category">' . ucfirst(htmlspecialchars($row["item_category"])) . '</div>
                <div class="price">₹' . number_format($row["price"], 2) . '</div>
                <form method="post" class="edit-form">
                    <input type="hidden" name="menu_id" value="' . $row["menu_id"] . '">
                    <input type="number" name="available_qty" value="' . $row["available_qty"] . '" min="0">
                    <button type="submit">Update Quantity</button>
                </form>
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
