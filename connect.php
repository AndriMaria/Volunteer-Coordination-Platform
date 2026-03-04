<?php


$servername = "NAME OF YOUR SERVER";
$username = "YOUR USERNAME";
$password = "YOUR PASSWORD";
$dbname = "naturaldisaster";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>