<?php
session_start();
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    if (!empty($username) && !empty($email) && !empty($password)) {
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

        if (mysqli_query($con, $query)) {
            echo "<script>alert('Registration Successful!');</script>";
            header("Location: login.php");
            exit();
        } else {
            echo "<script>alert('Error: Could not register.');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all fields.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ECOALERT</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <div class="login-container">
        <h1>Register</h1>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Register">
        </form>
        <a href="login.php">Already have an account? Login here</a>
    </div>
</body>
</html>
