<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['temp_user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $security_answer = strtolower(trim($_POST['security_answer']));
    
    $sql = "SELECT security_answer, role FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['temp_user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        if ($security_answer == strtolower($row['security_answer'])) {
            $_SESSION['user_id'] = $_SESSION['temp_user_id'];
            unset($_SESSION['temp_user_id']);
            
            if ($row['role'] == 'admin') {
                header("Location: index_admin.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            echo "Incorrect security answer.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify 2FA</title>
    <link rel="stylesheet" href="werify.css">
</head>
<body>
    
    <form method="POST">
    <h2>Security Question Verification</h2>
        <label><?= ($_SESSION['security_question'] == 'pet') ? 'What is the name of your first pet?' : 'What is the name of your elementary school?' ?></label><br>
        <input type="text" name="security_answer" required><br>
        <button type="submit">Verify</button>
    </form>
</body>
</html>
