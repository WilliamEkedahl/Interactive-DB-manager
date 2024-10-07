<?php
session_start();
require("includes/dbh.inc.php"); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Verifies the hashed password)
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: index.php"); // Redirect to index page
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No user found with that username.";
    }
}
?>

<!DOCTYPE html>
<html lang="no">
<head>
    <title>Login</title>
</head>
<body>
<h2>Login</h2>
<form method="POST" action="login.php">
    <label>
        Username:
        <input type="text" name="username" required>
    </label><br>
    <label>
        Password:
        <input type="password" name="password" required>
    </label><br>
    <button type="submit">Login</button>

    <h1> Now you cant fill in junk data into my database anymore :P</h1>
</form>
</body>
</html>