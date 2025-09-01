<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>About Us - Library Management System</title>
    <link rel="stylesheet" href="about.css">
</head>
<body style="background-image: url('images/library1.jpeg'); background-size: cover; background-position: center center; background-repeat: no-repeat;">

<header>
    <div class="logo">
        <img src="images/logo.png" alt="Library Logo">
        <h1>Library Management System</h1>
    </div>
    <nav>
        <a href="index.php">Home</a>
        <a href="authentication/register.php">Register</a>
        <a href="authentication/login.php">Login</a>
        <a href="about.php" class="active">About Us</a>
        <a href="contact.php">Contact</a>
    </nav>
</header>

<main>
    <div class="about-container">
        <h1>About Us</h1>

        <p>Welcome to the <strong>Library Management System</strong>, your digital gateway to a world of knowledge. 
           Our mission is to make library services <em>simple, efficient, and accessible</em> for everyone whether you're a student, researcher, or an avid reader.</p>
        
        <p>We believe a library is more than just a collection of books; it's a <strong>community hub</strong> for learning and inspiration. 
           With this system, we bring the library to your fingertips anytime, anywhere.</p>

        <h3>What We Offer:</h3>
        <ul>
            <li>Role-based access for Admin, Librarian, and Member</li>
            <li>Book issuing and returning made easy</li>
            <li>Fine tracking and online payments</li>
            <li>Real-time book availability search</li>
            <li>User-friendly and responsive interface</li>
        </ul>

        <h3>Our Vision:</h3>
        <p>To empower readers and librarians by combining <strong>traditional library values</strong> with <strong>modern technology</strong>, ensuring that knowledge is never more than a click away.</p>

        <h3>Our Commitment:</h3>
        <p>We are dedicated to keeping our library organized, accessible, and responsive — so you can focus on what matters most: 
           <em>reading, learning, and growing</em>.</p>
    </div>
</main>

<footer>
    &copy; <?php echo date("Y"); ?> Library Management System. All rights reserved.
</footer>

</body>
</html>
