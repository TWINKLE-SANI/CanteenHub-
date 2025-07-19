<?php
session_start();

if (isset($_SESSION['errors'])) {
    $data = $_SESSION['errors'];
} else {
    $data = [];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="formbold-main-wrapper">
        <h1 class="site-title">CanteenHub+</h1>
  <div class="formbold-form-wrapper">
    <form id = "signup-form" action="signUp_validate.php" method="POST">
      <div class="formbold-input-group">
        <label for="firstname" class="formbold-form-label"> Name </label>
        <input
          type="text"
          name="firstname"
          id="firstname"
          placeholder="Enter your name"
          class="formbold-form-input"
        />
        <span class="error" id="firstname-error"></span>
        <?php
        if(isset($data['firstnameErr'])){
            if ($data['firstnameErr']) {
              echo '<div class="error">' . $data['firstnameErr'] . '</div>';
            }
        }
        ?>
      </div>

      <div class="formbold-input-group">
        <label for="passwrd" class="formbold-form-label"> Password</label>
        <input
          type="passwrd"
          name="passwrd"
          id="passwrd"
          placeholder="Enter your password"
          class="formbold-form-input"
        />
        <span class="error" id="passwrd-error"></span>
        <?php
        if(isset($data['passwrdErr'])){
            if ($data['passwrdErr']) {
              echo '<div class="error">' . $data['passwrdErr'] . '</div>';
            }
        }
        ?>
      </div>

      <div class="formbold-input-group">
        <label for="email" class="formbold-form-label"> Email </label>
        <input
          type="text"
          name="email"
          id="email"
          placeholder="Enter your email"
          class="formbold-form-input"
        />
        <span class="error" id="email-error"></span>
        <?php
        if(isset($data['emailErr'])){
            if ($data['emailErr']) {
              echo '<div class="error">' . $data['emailErr'] . '</div>';
            }
        }
        ?>
      </div>

      <div class="formbold-input-group">
        <label for="phone" class="formbold-form-label"> Phone Number </label>
        <input
          type="numeric"
          name="phone"
          id="phone"
          placeholder="Enter your phone number"
          class="formbold-form-input"
        />
        <span class="error" id="phone-error"></span>
        <?php
        if(isset($data['phoneErr'])){
            if ($data['phoneErr']) {
              echo '<div class="error">' . $data['phoneErr'] . '</div>';
            }
        }
        ?>
      </div>
    
      <button type="submit" class="formbold-btn">Submit</button>
      <p class="formbold-form-label">Already have an account?
        <button type=button onclick="window.location.href='login.php'" class="formbold-btn">Log In</button>
      </p>
    </form>
        </div>
        </div>
</body>
</html>


<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

  body {
    font-family: 'Inter', sans-serif;
    background-color: #040200ff;
    margin: 0;
    padding: 0;
  }

  .formbold-main-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 48px;
    background-color: #090909ff;
  }

  .formbold-form-wrapper {
    margin: 0 auto;
    max-width: 570px;
    width: 100%;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    padding: 40px;
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
  }

  .formbold-btn:hover {
    background-color: #e65c00;
    box-shadow: 0px 3px 12px rgba(255, 107, 0, 0.2);
  }

  .formbold-form-wrapper p {
    text-align: center;
    margin-top: 20px;
    color: #5D4037;
    font-size: 14px;
  }

  .formbold-form-wrapper button[type="button"] {
    margin-top: 10px;
    width: auto;
    padding: 10px 20px;
    font-size: 14px;
    background-color: transparent;
    color: #FF6B00;
    border: 2px solid #FF6B00;
    border-radius: 6px;
    font-weight: 600;
    transition: background-color 0.3s, color 0.3s;
  }

  .formbold-form-wrapper button[type="button"]:hover {
    background-color: #FF6B00;
    color: white;
  }

  .error {
    color: #D32F2F;
    font-size: 13px;
    margin-top: 6px;
    font-weight: 500;
  }
.site-title {
  text-align: center;
  font-size: 48px;
  font-weight: 700;
  font-family: 'Playfair Display', serif;
  color: #FF6B00;
  margin-top: 20px;
  margin-bottom: 20px;
  letter-spacing: 1.2px;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.08);
}

</style>

<script>
    const form=document.getElementById("signup-form");

    document.getElementById("firstname").addEventListener("input", function () {
      const value = this.value.trim();
      if (!/^[A-Za-z]+$/.test(value)) {
        document.getElementById("firstname-error").innerHTML = "Please enter only letters.";
      } else {
        document.getElementById("firstname-error").innerHTML = "";
      }
    });


    document.getElementById("passwrd").addEventListener("input", function () {
      const value = this.value.trim();
      if (value.length < 6) {
        document.getElementById("passwrd-error").innerHTML = "At least 6 characters.";
      } else {
        document.getElementById("passwrd-error").innerHTML = "";
      }
    });

    document.getElementById("email").addEventListener("input", function () {
      const value = this.value.trim();
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
        document.getElementById("email-error").innerHTML = "Please enter a valid email.";
      } else {
        document.getElementById("email-error").innerHTML = "";
      }
    });

    document.getElementById("phone").addEventListener("input", function () {
      const value = this.value.trim();
      if (!/^\d{10}$/.test(value)) {
        document.getElementById("phone-error").innerHTML = "Enter exactly 10 digits.";
      } else {
        document.getElementById("phone-error").innerHTML = "";
      }
    });

    form.addEventListener("submit", function(event) {
  event.preventDefault();

  const firstname = document.getElementById("firstname").value.trim();
  const passwrd = document.getElementById("passwrd").value.trim();
  const email = document.getElementById("email").value.trim();
  const phone = document.getElementById("phone").value.trim();

  let isValid = true;

  if (!firstname) {
    document.getElementById("firstname-error").textContent = "Please enter your firstname.";
    isValid = false;
  } else if (!/^[A-Za-z]+$/.test(firstname)) {
    document.getElementById("firstname-error").textContent = "Please enter only letters.";
    isValid = false;
  } else {
    document.getElementById("firstname-error").textContent = "";
  }

  if (!passwrd) {
    document.getElementById("passwrd-error").textContent = "Please enter your password.";
    isValid = false;
  } else if (passwrd.length < 6) {
    document.getElementById("passwrd-error").textContent = "Password must be at least 6 characters.";
    isValid = false;
  } else {
    document.getElementById("passwrd-error").textContent = "";
  }

  if (!email) {
    document.getElementById("email-error").textContent = "Please enter your email.";
    isValid = false;
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    document.getElementById("email-error").textContent = "Please enter a valid email.";
    isValid = false;
  } else {
    document.getElementById("email-error").textContent = "";
  }

  if (!phone) {
    document.getElementById("phone-error").textContent = "Please enter your phone number.";
    isValid = false;
  } else if (!/^\d{10}$/.test(phone)) {
    document.getElementById("phone-error").textContent = "Phone number must be exactly 10 digits.";
    isValid = false;
  } else {
    document.getElementById("phone-error").textContent = "";
  }

  if (isValid) {
    this.submit();
  }
});
</script>