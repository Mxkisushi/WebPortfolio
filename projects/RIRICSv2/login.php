<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['temp_user_id'] = $row['id']; // Store temporarily for 2FA
            $_SESSION['security_question'] = $row['security_question'];
            header("Location: verify_2fa.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="TITLE">
        <h1 style="color:#273043;">Log In</h1>
    </div>
    <form method="POST">
    <h1>RIRICS</h1>
        <div class="fill">
            <label for="username">Username</label><br>
            <input type="text" name="username" required><br>

            <label for="password">Password</label><br>
            <input type="password" name="password" id="password" required>
        </div>
        <div class="no-break">
            <input type="checkbox" id="pass" onclick="togglePassword()"> Show Password
        </div>
        

        <button type="submit">Log In</button>
    </form>
    <div class="reg-btn">
        <p>Doesn't have an account yet?</p>
        <a href="register.php"><button type="submit">Register Now</button></a>
    </div>
    <script>
        function togglePassword() {
            var password = document.getElementById("password");
            password.type = (password.type === "password") ? "text" : "password";
        }
    </script>
</body>
</html>
