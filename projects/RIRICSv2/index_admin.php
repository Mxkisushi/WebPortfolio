<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
   
    <header>
        <nav class="navbar">
            <div class="logo">
                <h1>RIRICS</h1>
                <h6>RIRICS - Discover Lyrics & Songs</h6>
            </div>
            <div class="nav_links">
                <a href="index_admin.php">Home</a>
                <a href="#feat">Featured</a>
                <a href="#charts">Charts</a>
                <a href="#about">About</a>
            </div>
            <div class="search-bar">
                <form action="search.php" method="GET">
                <input type="text" id="searchInput" name="query" placeholder="Search for songs..." autocomplete="off" spellcheck="false">
                <div id="suggestions" class="suggestions-box"></div>
                <button type="submit">Search</button>
                <a href="logout.php" id="logout">Log Out</a>
            </div>  
            
        </nav>
    </header>

    <section id="feat" class>
    <div id="featured" class="featured">
        <h2>Most Popular Songs</h2>
        <div class="carousel">
            <div class="carousel-container">
                <?php
                include 'db_connect.php';
                $sql = "SELECT id, title, artist, img FROM songs";
                $result = $conn->query($sql);
                
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='carousel-item'>
                        <img src='data:image/jpeg;base64," . base64_encode($row['img']) . "' alt='{$row['title']}'>
                        <div class='carousel-text'>
                            <h3>{$row['title']}</h3>
                            <h3>{$row['artist']}</h3>
                            <a href='view_lyrics.php?id={$row['id']}'>View Lyrics</a>
                        </div>
                    </div>";
                }
                ?>
            </div>
            <div class="carousel-dots"></div>
        </div>
    </div>
    </section>

    <section id="charts">
    <div class="charts" >
        <h1>Charts</h1>

        <div class="add">
            <button id="addSongBtn">Add Song</button>
        </div>

        <table>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                <th>Artist</th>
                <th>Action</th>
            </tr>
            <?php
            include 'db_connect.php';
            $sql = "SELECT id, title, artist, img FROM songs";
            $result = $conn->query($sql);
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td><img src='data:image/jpeg;base64," . base64_encode($row['img']) . "' width='100' height='100'></td>
                    <td>{$row['title']}</td>
                    <td>{$row['artist']}</td>
                    <td><button onclick='viewLyrics({$row['id']})'>View</button></td>
                </tr>";
            }
            ?>
        </table>
        </div>

        <div id="addSongModal" class="modal">
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <h2>Add Song</h2>
                <form action="add_song.php" method="POST" enctype="multipart/form-data">
                    <input type="text" name="title" placeholder="Song Title" required>
                    <input type="text" name="artist" placeholder="Artist" required>
                    <input type="file" name="img" accept="image/*" required>
                    <textarea name="lyrics" placeholder="Lyrics" required></textarea>
                    <button type="submit">Add Song</button>
                </form>
            </div>
    </div>
    </section>


    <footer>
        <div id="about" class="about">
            <h2>About</h2>
            <p>&copy; 2025 RIRICS. All rights reserved.</p>
        </div>
    </footer>
    
    <script src="script.js"></script>
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