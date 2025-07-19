<?php
session_start();
$request_id = $_GET['request_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Status - Canteen Hub+</title>
    <!-- Google Fonts -->
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

        .status-container {
            margin-top: 80px;
            text-align: center;
        }

        #status {
            font-size: 28px;
            margin-top: 30px;
            color: #ff5733;
        }

        .loader {
            margin-top: 30px;
            border: 6px solid #333;
            border-top: 6px solid #ff5733;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        strong {
            color: #fff;
        }
    </style>
    <script>
        function checkStatus() {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "check_order_status.php?request_id=<?= $request_id ?>", true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    const statusDiv = document.getElementById("status");

                    if (response.status === "accepted") {
                        statusDiv.innerHTML = "✅ Order Confirmed!<br><br>Pickup Time: <strong>" + response.pickup_time + "</strong>";
                        document.querySelector(".loader").style.display = "none";
                        clearInterval(checkInterval);
                    } else if (response.status === "rejected") {
                        statusDiv.innerHTML = "❌ Sorry, your order was rejected.";
                        document.querySelector(".loader").style.display = "none";
                        clearInterval(checkInterval);
                    } else {
                        statusDiv.innerHTML = "⏳ Waiting for confirmation...";
                        document.querySelector(".loader").style.display = "inline-block";
                    }
                }
            };
            xhr.send();
        }

        const checkInterval = setInterval(checkStatus, 3000); // check every 3 seconds
        window.onload = checkStatus;
    </script>
</head>
<body>

<header>Canteen Hub+</header>

<nav>
    <a href="user_homePage.php">Menu</a>
    <a href="user_orders.php">Orders</a>
</nav>

<div class="status-container">
    <h2>Your Order Status</h2>
    <div class="loader"></div>
    <div id="status">⏳ Waiting for confirmation...</div>
</div>

</body>
</html>
