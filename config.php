<?php
$host = "localhost";
$db = "perpusv1";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}