<?php
// add_song.php
include 'db_connect.php'; 

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $lyrics = $_POST['lyrics'];
    $img = file_get_contents($_FILES['img']['tmp_name']);

    $stmt = $conn->prepare("INSERT INTO songs (title, artist, lyrics, img) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssb", $title, $artist, $lyrics, $img);
    $stmt->send_long_data(3, $img);
    $stmt->execute();
    
    if (!$stmt->execute()) {
        die("SQL Error: " . $stmt->error);
    }

    // Redirect based on role
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        header("Location: index_admin.php");
    } else {
        header("Location: index.php");
    }
    exit();
}
?>