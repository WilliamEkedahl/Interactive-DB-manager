<?php

$servername = "localhost";
$username = "#redacted";
$password = "#redacted";
$dbname = "#redacted";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
 //Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
?>
