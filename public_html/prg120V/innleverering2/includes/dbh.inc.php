<?php

$servername = "localhost";
$username = "274640";
$password = "OIyOZzfa";
$dbname = "274640";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>