<?php
// view_lyrics.php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Lyrics</title>
    <style>
        @font-face {
            font-family: fontys;
            src: url(fontys/Technova\ PERSONAL\ USE\ ONLY!.ttf);
        }
        @font-face {
            font-family: fontz;
            src: url(fontys/AR\ Techni.ttf);
        }
        *{
            font-family: fontz;
        }
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 30px;
            background: linear-gradient(to top, #EFF6EE, #9197AE , #273043 );
        }
        nav {
            position: sticky;
            top: 0;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #333;
            padding: 10px 30px;
            color: white;
            background-color: #9197AE;
            margin: fixed;
            border-radius: 30px;
        }
        nav.scrolled {
            border-radius: 0 0 30px 30px;
            background-color: #9197AE;
        }
        .navbar h1{
            font-family: fontys;
            margin-bottom: -15px;
            margin-top: 10px;
            font-size: 40px;
            margin-left: 70px;
            color: #273043;
        }
        .navbar h6{
            font-family: 'poppins';
            margin-left: 70px;
            font-size: 15px;
            margin-top: 10px;
            margin-bottom: 15px;
            color: #EFF6EE;
            font-family: fontz;
        }
        .navbar a:hover {
            background-color: #EFF6EE;
            color: #273043;
            border-bottom: 5px solid #273043;
            text-decoration: none;
        }
        .nav-links a {
            color: #EFF6EE;
            height: 20px;
            margin-top: 0;
            align-content: center;
            justify-content: center;
            align-items: center;
            padding: 10px;
            border-radius: 10px;
            position: relative;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
            font-size: 20px;
        }
        .nav-links a:hover {
            font-weight: bold;
            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
            transform: translateX(smooth);
        }
        .lyrics-container {
            max-width: 900px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 20px 0#EFF6EE;
            background-color: #273043;
        }
        .lyrics-container h1 {
            color: #EFF6EE;
            font-size: 40px;
            font-family: fontys;
        }
        pre {
            white-space: pre-wrap;
            font-size: 18px;
            text-align: left;
            line-height: 1.6;
            color: #EFF6EE;
        }
        .suggested-songs {
            max-width: 800px;
            margin: 20px auto;
            background: #EFF6EE;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 20px 0 #273043;
        }
        .suggested-songs h2 {
            font-size: 20px;
            color: #273043;
            font-family: fontys;
            font-size: 40px;
            margin-bottom: 10px;
        }
        .suggested-songs ul {
            list-style-type: none;
            padding: 10px;
            display: flex;
            flex-direction: colums;
        }
        .suggested-songs li {
            padding: 20px;
            border-bottom: 1px solid #ddd;
        }
        .suggested-songs a {
            text-decoration: none;
            color: #273043;
            font-weight: bold;
        }
        .suggested-songs a:hover {
            text-decoration: underline;
            color: #273043;
        }
        .search-bar {
            display: flex;
            align-items: center;
        }

        .search-bar input {
            padding: 8px;
            border: none;
            border-radius: 5px;
            margin-right: 10px;
            width: 200px;
        }

        .search-bar button {
            background: #273043;
            color: #EFF6EE;
            border: none;
            padding: 8px 15px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            font-size: 20px;
        }

        .search-bar button:hover {
            background: #EFF6EE;
            color: #273043; 
        }
        .suggestion{
            color: #273043;
        }
        .suggestions-box {
            position: absolute;
            background: #EFF6EE;
            color: #273043;
            border: 1px solid #ccc;
            width: 210px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 10;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .suggestion-item {
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #ddd;
            color: #273043;
            background-color: #EFF6EE;
        }

        .suggestion-item:hover {
            color: #EFF6EE;
            background-color: #273043;
        }
        footer {
            margin-top: 5rem;
            background: #273043;
            color: #EFF6EE;
            padding: 20px; 
            border-radius: 30px;
        }   
        .close-btn {
            font-size: 20px;
            padding-top: 30rem;
            padding: 10px;
            padding-left: 20px;
            padding-right: 20px;
            border-radius: 30px;
            cursor: pointer;
            color:#273043;
            text-decoration: none;
            margin-bottom: -50px;
            margin-top: 3rem;
            position: relative;
            background-color: #EFF6EE;
        }          
        .close-btn:hover{
            border-bottom: 5px solid #9197AE;
        } 
    </style>
</head>
<body>

<!-- Navbar -->
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


<!-- Lyrics Content -->
 

<div class="lyrics-container">
<a href="index_admin.php" class="close-btn">Back to homepage</a>
    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT title, artist, lyrics FROM songs WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<h1>{$row['title']} - {$row['artist']}</h1>";
            echo "<pre>{$row['lyrics']}</pre>";
        } else {
            echo "<p>Lyrics not found.</p>";
        }
    }
    ?>
</div>

<!-- Suggested Songs Section -->
<div class="suggested-songs">
    <h2>Suggested Songs</h2>
    <ul>
        <?php
        // Fetch 5 random songs from the database (excluding the current song)
        $sql_suggestions = "SELECT id,  title, artist FROM songs WHERE id != ? ORDER BY RAND() LIMIT 5";
        $stmt_suggestions = $conn->prepare($sql_suggestions);
        $stmt_suggestions->bind_param("i", $id);
        $stmt_suggestions->execute();
        $result_suggestions = $stmt_suggestions->get_result();

        if ($result_suggestions->num_rows > 0) {
            while ($suggested_song = $result_suggestions->fetch_assoc()) {
                
                echo "<li><a href='view_lyrics.php?id={$suggested_song['id']}'>{$suggested_song['title']} - {$suggested_song['artist']}</a></li>";
            }
        } else {
            echo "<li>No suggested songs available.</li>";
        }
        ?>
    </ul>
</div>
    <footer>
        <div id="about" class="about">
            <h2>About</h2>
            <p>&copy; 2025 RIRICS. All rights reserved.</p>
        </div>
    </footer>
<script >
    window.addEventListener("scroll", function() {
        let navbar = document.querySelector(".navbar");
        if (window.scrollY > 50) { // When scrolled 50px down
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }
    });
</script>
</body>
</html>
