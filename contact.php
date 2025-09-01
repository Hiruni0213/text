<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Contact - Library Management System</title>
    <style>
        /* Reset */
        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
          font-family: "Segoe UI", sans-serif;
        }

        body {
          background: url('images/library.jpeg') no-repeat center center fixed;
          background-size: cover;
          filter: brightness(0.85) saturate(0.8);
          color: #333;
          display: flex;
          flex-direction: column;
          min-height: 100vh;
        }

        /* Header */
        header {
          display: flex;
          justify-content: space-between;
          align-items: center;
          padding: 15px 40px;
          background: #0b63b8;
          color: white;
        }

        header .logo {
          display: flex;
          align-items: center;
          gap: 12px;
        }

        header .logo img {
          width: 45px;
          height: 45px;
          border-radius: 6px;
        }

        header nav a {
          color: white;
          text-decoration: none;
          margin: 0 15px;
          font-weight: 500;
          transition: color 0.3s;
        }

        header nav a:hover,
        header nav a.active {
          color: #ffdd57;
        }

        /* Main */
        main {
          flex: 1;
          display: flex;
          justify-content: center;
          align-items: flex-start;
          padding: 40px 20px;
        }

        .contact-container {
          max-width: 900px;
          width: 100%;
          background-color: rgba(255, 255, 255, 0.95);
          border-radius: 10px;
          padding: 30px;
          box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }

        .contact-container h1 {
          text-align: center;
          color: #004085;
          margin-bottom: 30px;
        }

        .contact-grid {
          display: flex;
          flex-wrap: wrap;
          gap: 30px;
        }

        .contact-info, .contact-form {
          flex: 1 1 400px;
        }

        .contact-info h3, .contact-form h3 {
          color: #004085;
          margin-bottom: 15px;
        }

        .contact-info p {
          margin: 10px 0;
          font-size: 16px;
        }

        .contact-form input, .contact-form textarea {
          width: 100%;
          padding: 10px;
          margin-bottom: 15px;
          border: 1px solid #ccc;
          border-radius: 5px;
        }

        .contact-form input[type="submit"] {
          background-color: #004085;
          color: white;
          border: none;
          cursor: pointer;
        }

        .contact-form input[type="submit"]:hover {
          background-color: #002752;
        }

        .map {
          margin-top: 20px;
        }

        .back-home {
          display: inline-block;
          margin-top: 20px;
          padding: 10px 20px;
          background-color: #004085;
          color: white;
          text-decoration: none;
          border-radius: 5px;
        }

        .back-home:hover {
          background-color: #002752;
        }

        /* Responsive */
        @media(max-width: 768px) {
          header {
            flex-direction: column;
            gap: 10px;
            text-align: center;
          }

          header nav a {
            display: block;
            margin: 10px 0;
          }

          .contact-grid {
            flex-direction: column;
          }
        }

        /* Footer */
        footer {
          margin-top: auto;
          background: #0b63b8;
          color: white;
          text-align: center;
          padding: 15px 0;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="Images/logo.png" alt="Library Logo">
        <h1>Library Management System</h1>
    </div>
    <nav>
        <a href="index.php">Home</a>
        <a href="authentication/register.php">Register</a>
        <a href="authentication/login.php">Login</a>
        <a href="about.php">About Us</a>
        <a href="contact.php" class="active">Contact</a>
    </nav>
</header>

<main>
    <div class="contact-container">
        <h1>Contact Us</h1>

        <div class="contact-grid">
            <!-- Contact Info -->
            <div class="contact-info">
                <h3>Get in Touch</h3>
                <p><strong>Address:</strong> 45 Library Rd, Colombo, Sri Lanka</p>
                <p><strong>Phone:</strong> +94 112 345 678</p>
                <p><strong>Email:</strong> info@library.com</p>
                <p><strong>Working Hours:</strong> Mon - Sat: 9:00 AM - 6:00 PM</p>

                <div class="map">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3163.106622291381!2d79.86124341508905!3d6.927078895017066!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25902df3bfc1b%3A0x6f7ff1ed0f8db55b!2sColombo%2C%20Sri%20Lanka!5e0!3m2!1sen!2sus!4v1692025612345!5m2!1sen!2sus" 
                        width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form">
                <h3>Send a Message</h3>
                <form action="send_message.php" method="POST">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <textarea name="message" rows="6" placeholder="Your Message" required></textarea>
                    <input type="submit" value="Send Message">
                </form>
            </div>
        </div>

        <a href="index.php" class="back-home">Back to Home</a>
    </div>
</main>

<footer>
    &copy; <?php echo date("Y"); ?> Library Management System. All rights reserved.
</footer>

</body>
</html>
