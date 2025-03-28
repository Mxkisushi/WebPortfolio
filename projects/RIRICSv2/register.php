<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $security_question = $_POST['security_question'];
    $security_answer = trim(strtolower($_POST['security_answer'])); // Case-insensitive match

    if (empty($username) || empty($email) || empty($password) || empty($security_question) || empty($security_answer)) {
        echo "All fields are required.";
        exit();
    }

    $checkUser = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $checkUser->bind_param("ss", $username, $email);
    $checkUser->execute();
    $result = $checkUser->get_result();

    if ($result->num_rows > 0) {
        echo "Username or Email already exists. Try another one.";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $checkUsers = $conn->query("SELECT COUNT(*) as count FROM users");
    $row = $checkUsers->fetch_assoc();
    $role = ($row['count'] == 0) ? 'admin' : 'user';

    $sql = "INSERT INTO users (username, email, password, role, security_question, security_answer) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $username, $email, $hashed_password, $role, $security_question, $security_answer);

    if ($stmt->execute()) {
        echo "Registration successful. <a href='login.php'>Login here</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="regstyle.css">
</head>
<body>
    <div class="TITLE">
    <h1 style="color:#273043;">Registration Form</h1>
    </div>
    <form method="POST">
    <h1>RIRICS</h1>
        <div class="fill">
        <label for="username">Username</label><br>
        <input type="text" name="username" required><br>

        <label for="email">Email</label><br>
        <input type="email" name="email" required><br>

        <label for="password" >Password</label><br>
        <input type="password" name="password" id="password" required>
        </div>
        <div class="no-break">
            <input type="checkbox" id="pass" onclick="togglePassword()"> Show Password
        </div>



        <label for="security_question" class="kwischon">Security Question</label><br>
        <select name="security_question" required>
            <option value="">Select a question...</option>
            <option value="pet">What is the name of your first pet?</option>
            <option id="sc" value="school">What is the name of your elementary school?</option>
        </select><br>

        <label for="security_answer">Answer</label><br>
        <input type="text" name="security_answer" required><br>
        <div class="no-break">
        <input type="checkbox"  required> I agree to the <a href="terms.php">Terms and Conditions</a><br>
        </div>
        <button type="submit">Register</button>
    </form>
        <div class="log-btn">
        <a href="login.php"><button type="submit">Back to Login</button></a>
        </div>


        
   

    <script>
        function togglePassword() {
            var password = document.getElementById("password");
            password.type = (password.type === "password") ? "text" : "password";
        }
    </script>
</body>
</html>
