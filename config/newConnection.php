<html>
<head>

</head>

<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
?>
</body>
</html>
