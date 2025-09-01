<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Library Management System</title>
  <link rel="stylesheet" href="index.css">
  
</head>
<body>

<header>
  <div class="logo">
    <img src="images/logo.png" alt="Library Logo">
    <h2>Library Management System</h2>
  </div>
  <nav>
    <a href="index.php" class="active">Home</a>
    <a href="authentication/register.php">Register</a>
    <a href="authentication/login.php">Login</a>
    <a href="about.php">About Us</a>
    <a href="contact.php">Contact</a>
  </nav>
</header>

<main>
  <section class="hero">
    <h1>Welcome to Our Digital Library</h1>
    <p>Access, manage, and explore books with ease.</p>
    <div class="buttons">
      <a href="authentication/register.php" class="btn">Get Started</a>
      <a href="authentication/login.php" class="btn secondary">Login</a>
    </div>
  </section>

  <section class="features">
    <div class="feature">
      <i class="fas fa-book"></i>
      <h3>Books Collection</h3>
      <p>Browse thousands of books instantly.</p>
    </div>
    <div class="feature">
      <i class="fas fa-user-friends"></i>
      <h3>Manage Members</h3>
      <p>Keep track of registered users.</p>
    </div>
    <div class="feature">
      <i class="fas fa-handshake"></i>
      <h3>Borrow & Return</h3>
      <p>Simple tracking of issued books.</p>
    </div>
    <div class="feature">
      <i class="fas fa-coins"></i>
      <h3>Fine Management</h3>
      <p>Automatic late fine calculation.</p>
    </div>
  </section>
</main>

<footer>
  <p>&copy; <?php echo date("Y"); ?> Library Management System. All rights reserved.</p>
</footer>

</body>
</html>
