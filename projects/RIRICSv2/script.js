/* script.js */
document.getElementById("addSongBtn").addEventListener("click", function() {
    document.getElementById("addSongForm").style.display = "block";
});

function viewLyrics(id) {
    window.location.href = `view_lyrics.php?id=${id}`;
}


let index = 0;
function nextSlide() {
    const container = document.querySelector('.carousel-container');
    const total = document.querySelectorAll('.carousel-item').length;
    index = (index + 1) % total;
    container.style.transform = `translateX(-${index * 100}%)`;
}
setInterval(nextSlide, 3000);

document.getElementById("addSongBtn").addEventListener("click", function() {
    document.getElementById("addSongModal").style.display = "flex"; // Make it visible
});

document.querySelector(".close-btn").addEventListener("click", function() {
    document.getElementById("addSongModal").style.display = "none"; // Hide the modal
});

// Close modal when clicking outside the content
window.onclick = function(event) {
    let modal = document.getElementById("addSongModal");
    if (event.target === modal) {
        modal.style.display = "none";
    }
};

//SEARCH
document.getElementById("searchInput").addEventListener("input", function () {
    let query = this.value;

    if (query.length === 0) {
        document.getElementById("suggestions").innerHTML = "";
        return;
    }

    fetch("search_suggestions.php?query=" + query)
        .then(response => response.json())
        .then(data => {
            let suggestionsBox = document.getElementById("suggestions");
            suggestionsBox.innerHTML = "";

            data.forEach(song => {
                let suggestion = document.createElement("div");
                suggestion.classList.add("suggestion-item");
                suggestion.textContent = song.title + " - " + song.artist;
                suggestion.dataset.songId = song.id;

                suggestion.addEventListener("click", function () {
                    window.location.href = "view_lyrics.php?id=" + this.dataset.songId;
                });

                suggestionsBox.appendChild(suggestion);
            });
        })
        .catch(error => console.error("Error fetching suggestions:", error));
});
