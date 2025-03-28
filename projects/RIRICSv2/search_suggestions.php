<?php
include 'db_connect.php';

if (isset($_GET['query'])) {
    $query = "%" . $_GET['query'] . "%";

    $stmt = $conn->prepare("SELECT id, title, artist FROM songs WHERE title LIKE ? OR artist LIKE ?");
    $stmt->bind_param("ss", $query, $query);
    $stmt->execute();
    $result = $stmt->get_result();

    $songs = [];
    while ($row = $result->fetch_assoc()) {
        $songs[] = $row;
    }

    echo json_encode($songs);
}
?>
