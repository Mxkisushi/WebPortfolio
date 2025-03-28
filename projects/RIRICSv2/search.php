<?php
include 'db_connect.php';

if (isset($_GET['query'])) {
    $search = "%" . $conn->real_escape_string($_GET['query']) . "%";
    
    // Get search results
    $sql = "SELECT id, title, artist FROM songs WHERE title LIKE ? OR artist LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();

    // Get random suggested songs (LIMIT 5)
    $suggested_sql = "SELECT id, title, artist, img FROM songs ORDER BY RAND() LIMIT 5";
    $suggested_result = $conn->query($suggested_sql);
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Results</title>
    <link rel="stylesheet" href="search.css">
</head>
<body>

    <nav class="navbar">
        <div class="logo">
            <h1>RIRICS</h1>
            <h6>RIRICS - Discover Lyrics & Songs</h6>
        </div>
        <div class="nav-links">
            <a href="index_admin.php">Home</a>
            <a href="#featured">Featured</a>
            <a href="#charts">Charts</a>
            <a href="#about">About</a>
        </div>
        <div class="search-bar">
            <form action="search.php" method="GET">
                <input type="text" id="searchInput" name="query" placeholder="Search for songs..." autocomplete="off" spellcheck="false">
                <div id="suggestions" class="suggestions-box"></div>
                <button type="submit">Search</button>
            </form>
        </div>  
    </nav>

    
        <section class="charts">
        <h1>Search Results</h1>
        <table>
            <tr>
                <th>Title</th>
                <th>Artist</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['artist']) ?></td>
                    <td><a href="view_lyrics.php?id=<?= $row['id'] ?>">View Lyrics</a></td>
                </tr>
            <?php } ?>
        </table>
        </section>
        

    <section class="sugg">
    <h1>Suggested Songs</h1> 
    <div class="suggested-songs">
        <?php while ($s_row = $suggested_result->fetch_assoc()) { ?>
            <div class="suggested-item">
                <a href="view_lyrics.php?id=<?= $s_row['id'] ?>">
                    <img src="data:image/jpeg;base64,<?= base64_encode($s_row['img']) ?>" alt="<?= htmlspecialchars($s_row['title']) ?>" width="100" height="100">
                    <p><?= htmlspecialchars($s_row['title']) ?> - <?= htmlspecialchars($s_row['artist']) ?></p>
                </a>
            </div>
        <?php } ?>
    </div>
    </section>
</body>
</html>
