<?php
$host = "localhost";
$user = "root";  // change if necessary
$pass = "";
$dbname = "health_system";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
