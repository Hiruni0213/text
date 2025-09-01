<?php
session_start();
include 'config/newConnection.php'; // adjust path if needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message)) {
        // Escape values to prevent SQL injection
        $name = $conn->real_escape_string($name);
        $email = $conn->real_escape_string($email);
        $message = $conn->real_escape_string($message);

        // Insert into database
        $sql = "INSERT INTO contact_messages (name, email, message, created_at) 
                VALUES ('$name', '$email', '$message', NOW())";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Message sent successfully!'); window.location.href='contact.php';</script>";
        } else {
            echo "<script>alert('Error: Could not send message.'); window.location.href='contact.php';</script>";
        }
    } else {
        echo "<script>alert('All fields are required!'); window.location.href='contact.php';</script>";
    }
}
?>
