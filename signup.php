<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    /* General Reset */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(135deg, #6b73ff, #000dff);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      background: #fff;
      padding: 40px 30px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 400px;
      transition: 0.3s ease;
    }

    .container:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
    }

    header {
      font-size: 1.8rem;
      font-weight: 600;
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    hr {
      border: none;
      height: 1px;
      background: #eee;
      margin-bottom: 20px;
    }

    .input-container {
      position: relative;
      margin-bottom: 20px;
    }

    .input-container i {
      position: absolute;
      top: 50%;
      left: 10px;
      transform: translateY(-50%);
      color: #888;
    }

    .input-field {
      width: 100%;
      padding: 12px 40px 12px 40px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 1rem;
      transition: all 0.3s ease;
    }

    .input-field:focus {
      border-color: #6b73ff;
      box-shadow: 0 0 5px rgba(107, 115, 255, 0.5);
      outline: none;
    }

    .toggle {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #888;
    }

    .btn {
      display: block;
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      background: #6b73ff;
      color: #fff;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn:hover {
      background: #000dff;
      transform: translateY(-2px);
    }

    .links {
      margin-top: 15px;
      text-align: center;
      font-size: 0.9rem;
      color: #555;
    }

    .links a {
      color: #6b73ff;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    .links a:hover {
      color: #000dff;
    }

    .message {
      background: #ffefef;
      color: #d8000c;
      padding: 10px 15px;
      border-left: 5px solid #d8000c;
      border-radius: 5px;
      margin-bottom: 15px;
      font-size: 0.9rem;
    }
  </style>
</head>

<body>
  <div class="container">
    <header>Sign Up</header>
    <hr>

    <?php
    session_start();
    include "connection.php";

    if (isset($_POST['register'])) {
      $name = $_POST['username'];
      $email = $_POST['email'];
      $pass = $_POST['password'];
      $cpass = $_POST['cpass'];

      $check = "SELECT * FROM users WHERE email='{$email}'";
      $res = mysqli_query($conn, $check);
      $passwd = password_hash($pass, PASSWORD_DEFAULT);

      if (mysqli_num_rows($res) > 0) {
        echo "<div class='message'>This email is already used. Try another one!</div>";
      } else {
        if ($pass === $cpass) {
          $sql = "INSERT INTO users(username,email,password) VALUES('$name','$email','$passwd')";
          if (mysqli_query($conn, $sql)) {
            echo "<div class='message' style='color:green;border-left-color:green;'>Registered successfully!</div>";
          } else {
            echo "<div class='message'>Registration failed. Try again!</div>";
          }
        } else {
          echo "<div class='message'>Passwords do not match.</div>";
        }
      }
    }
    ?>

    <form action="" method="POST">
      <div class="input-container">
        <i class="fa fa-user"></i>
        <input class="input-field" type="text" placeholder="Username" name="username" required>
      </div>

      <div class="input-container">
        <i class="fa fa-envelope"></i>
        <input class="input-field" type="email" placeholder="Email Address" name="email" required>
      </div>

      <div class="input-container">
        <i class="fa fa-lock"></i>
        <input class="input-field password" type="password" placeholder="Password" name="password" required>
        <i class="fa fa-eye toggle"></i>
      </div>

      <div class="input-container">
        <i class="fa fa-lock"></i>
        <input class="input-field" type="password" placeholder="Confirm Password" name="cpass" required>
        <i class="fa fa-eye toggle"></i>
      </div>

      <button type="submit" name="register" class="btn">Sign Up</button>

      <div class="links">
        Already have an account? <a href="login.php">Sign In Now</a>
      </div>
    </form>
  </div>

  <script>
    document.querySelectorAll(".toggle").forEach((toggleIcon, index) => {
      toggleIcon.addEventListener("click", () => {
        const input = toggleIcon.previousElementSibling;
        if (input.type === "password") {
          input.type = "text";
          toggleIcon.classList.replace("fa-eye", "fa-eye-slash");
        } else {
          input.type = "password";
          toggleIcon.classList.replace("fa-eye-slash", "fa-eye");
        }
      });
    });
  </script>
</body>

</html>

