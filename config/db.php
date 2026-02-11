<?php
$conn = new mysqli("127.0.0.1", "htu_user", "htu_pass123", "htu_martialarts", 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

