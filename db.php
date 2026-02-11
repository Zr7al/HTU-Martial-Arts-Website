<?php

$host = "127.0.0.1";
$user = "root";
$pass = "";
$db   = "htu_martial_arts";
$port = 3307;

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>




