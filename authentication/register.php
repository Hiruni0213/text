<?php
session_start();
include '../config/newConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if (empty($name) || empty($email) || empty($password) || empty($password2)) {
        $error = "Please fill all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($password !== $password2) {
        $error = "Passwords do not match.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email is already registered.";
        } else {
            $role = 'member';
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $password, $role);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Registration successful! You can now login.";
                header("Location: ../authentication/login.php");
                exit;
            } else {
                $error = "Error occurred during registration.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Register - Library Management System</title>
<style>
/* Reset & basics */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}
body {
    height: 100vh;
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;

    /* Background image */
    background-image: url('../images/library.jpg'); 
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
}

/* Semi-transparent form container */
.form-wrapper {
    background: rgba(255, 255, 255, 0.95); /* slightly transparent */
    padding: 30px 40px;
    border-radius: 8px;
    width: 360px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.25);
    text-align: center;
}

/* Headings */
h2 {
    margin-bottom: 24px;
    color: #343a40;
    font-weight: 600;
}

/* Labels & Inputs */
label {
    display: block;
    font-weight: 600;
    margin-bottom: 6px;
    color: #495057;
}
input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 18px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    font-size: 15px;
    transition: border-color 0.3s;
}
input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
    border-color: #495057;
    outline: none;
}

/* Submit Button */
input[type="submit"] {
    width: 100%;
    padding: 12px 0;
    background-color: #007bff;
    border: none;
    border-radius: 4px;
    color: white;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
input[type="submit"]:hover {
    background-color: #0056b3;
}

/* Back to Home Button */
.back-home {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 20px;
    background-color: #f0f0f0;
    color: #333;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    transition: background-color 0.3s ease, color 0.3s ease;
}
.back-home:hover {
    background-color: #007bff;
    color: white;
}

/* Messages */
.message {
    padding: 12px;
    margin-bottom: 18px;
    border-radius: 4px;
    font-weight: 600;
}
.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

/* Login link */
.login-link {
    text-align: center;
    margin-top: 14px;
    font-size: 14px;
}
.login-link a {
    color: #007bff;
    text-decoration: none;
    font-weight: 600;
}
.login-link a:hover {
    text-decoration: underline;
}
</style>
</head>
<body>

<div class="form-wrapper">
  <h2>Register</h2>

  <?php
  if (isset($error)) {
      echo "<div class='message error'>{$error}</div>";
  }
  if (isset($_SESSION['success'])) {
      echo "<div class='message success'>{$_SESSION['success']}</div>";
      unset($_SESSION['success']);
  }
  ?>

  <form method="post" action="">
    <label for="name">Full Name</label>
    <input type="text" id="name" name="name" placeholder="Your full name" required>

    <label for="email">Email Address</label>
    <input type="email" id="email" name="email" placeholder="you@example.com" required>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Enter password" required>

    <label for="password2">Confirm Password</label>
    <input type="password" id="password2" name="password2" placeholder="Confirm password" required>

    <input type="submit" value="Register">
  </form>

  <p class="login-link">Already have an account? <a href="login.php">Login here</a>.</p>

  <!-- Back to Home Button -->
  <a class="back-home" href="../index.php">← Back to Home</a>
</div>

</body>
</html>
