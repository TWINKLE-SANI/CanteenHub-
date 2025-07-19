<?php
require_once "database.php";

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_category = $_POST['item_category'];
    $item_name = $_POST['item_name'];
    $available_qty = intval($_POST['available_qty']);
    $price = floatval($_POST['price']);

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $target_dir = "images/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir);
        }

        $file_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . uniqid() . "_" . $file_name;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image_url = $target_file;
    } else {
        $image_url = "";
    }

    $stmt = $conn->prepare("INSERT INTO menu (item_category, item_name, available_qty, price, image_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssids", $item_category, $item_name, $available_qty, $price, $image_url);
    $stmt->execute();
    $stmt->close();
    header("Location: owner_homePage.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Item - Smart Canteen</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Monoton&family=Poppins&display=swap');

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

        .form-container {
            margin: 40px auto;
            width: 90%;
            max-width: 500px;
            background-color: #1a1a1a;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(255, 87, 51, 0.3);
        }

        h2 {
            text-align: center;
            color: #ff5733;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 8px;
            border: none;
            background-color: #333;
            color: white;
        }

        button {
            background-color: #ff5733;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            margin-top: 20px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #e64a19;
        }

        #preview {
            display: block;
            margin-top: 15px;
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 10px;
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

<div class="form-container">
    <form action="" method="post" enctype="multipart/form-data">
        <h2>Add New Menu Item</h2>

        <label for="item_category">Item Category</label>
        <select name="item_category" id="item_category" required>
            <option value="">-- Select Category --</option>
            <option value="meal">Meal</option>
            <option value="chai">Chai</option>
            <option value="snack">Snack</option>
        </select>

        <label for="item_name">Item Name</label>
        <input type="text" name="item_name" id="item_name" required>

        <label for="available_qty">Available Quantity</label>
        <input type="number" name="available_qty" id="available_qty" min="0" required>

        <label for="price">Price (₹)</label>
        <input type="number" name="price" id="price" step="0.01" min="0" required>

        <label for="image">Item Image</label>
        <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)" required>

        <img id="preview" style="display:none;" alt="Image Preview"/>

        <button type="submit">Add Item</button>
    </form>
</div>

<script>
    function previewImage(event) {
        const preview = document.getElementById("preview");
        const file = event.target.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = "block";
        } else {
            preview.src = "";
            preview.style.display = "none";
        }
    }
</script>

</body>
</html>
