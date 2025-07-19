<?php
session_start();

if (isset($_SESSION['login_error'])) {
    $data = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
} else {
    $data = [];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="formbold-main-wrapper">
        <h1 class="site-title">CanteenHub+</h1>
        <div class="formbold-form-wrapper">
          <?php
                if(isset($_SESSION['signup-success'])){
                    echo '<div class="success">' . $_SESSION['signup-success'] . '</div>';
                    unset($_SESSION['signup-success']);
                }
          ?>
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSYXcy3ExVToNO4T8PpaJgQCOrsTOCdtF0SNg&s">
            <form action="login_validate.php" method="POST" >
                <div class="formbold-input-group">
                    <label for="username" class="formbold-form-label"> Name</label>
                    <input
                    type="text"
                    name="username"
                    id="username"
                    placeholder="Enter your Name"
                    class="formbold-form-input"
                    />
                </div>
                <div class="formbold-input-group">
                    <label for="passwrd" class="formbold-form-label"> Password</label>
                    <input
                    type="password"
                    name="passwrd"
                    id="passwrd"
                    placeholder="Enter your password"
                    class="formbold-form-input"
                    autocomplete="off"
                    />
                </div>
                <?php
                if(isset($data)){
                    if ($data) {
                    echo '<div class="error">' . $data . '</div>';
                    }
                }
                ?>
                <button type="submit" class="formbold-btn">Log In</button>
            </form>
        </div>
    </div>
</body>
</html>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap');

  body {
    font-family: 'Inter', sans-serif;
    background-color: #080808ff;
    margin: 0;
    padding: 0;
  }

  .site-title {
    text-align: center;
    font-size: 48px;
    font-weight: 700;
    font-family: 'Playfair Display', serif;
    color: #FF6B00;
    margin-top: 30px;
    margin-bottom: 20px;
    letter-spacing: 1.2px;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.08);
  }

  .formbold-main-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 48px;
    background-color: #020202ff;
  }

  .formbold-form-wrapper {
    margin: 0 auto;
    max-width: 570px;
    width: 100%;
    background: #ffffff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
  }

  .formbold-input-group {
    margin-bottom: 20px;
  }

  .formbold-form-label {
    color: #3E2723;
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 8px;
    display: block;
  }

  .formbold-form-input {
    width: 100%;
    padding: 13px 18px;
    border-radius: 8px;
    border: 1.5px solid #FFB74D;
    background: #fff8f2;
    font-size: 15px;
    color: #3E2723;
    outline: none;
    transition: border-color 0.3s, box-shadow 0.3s;
  }

  .formbold-form-input:focus {
    border-color: #FF6B00;
    box-shadow: 0px 4px 10px rgba(255, 107, 0, 0.1);
  }

  .formbold-form-input::placeholder {
    color: #A1887F;
  }

  .formbold-btn {
    width: 100%;
    font-size: 16px;
    border-radius: 8px;
    padding: 14px 0;
    border: none;
    font-weight: 600;
    background-color: #FF6B00;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-top: 20px;
  }

  .formbold-btn:hover {
    background-color: #e65c00;
    box-shadow: 0px 3px 12px rgba(255, 107, 0, 0.2);
  }

  .error {
    color: #D32F2F;
    font-size: 13px;
    margin-top: 6px;
    font-weight: 500;
  }

  .success {
    color: green;
    font-size: 20px;
    margin-top: 5px;
    margin-bottom: 10px;
    text-align: center;
    font-weight: 500;
  }

  img {
    display: block;
    margin: 0 auto 30px auto;
    width: 180px;
    border-radius: 10px;
  }
</style>

