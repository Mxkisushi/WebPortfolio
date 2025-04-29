        document.addEventListener("DOMContentLoaded", function () {
        const hamburger = document.getElementById('menu-toggle');
        hamburger.classList.add("hamburger");
        hamburger.innerHTML = "☰";
        
        document.body.prepend(hamburger);
        
        const menu = document.querySelector(".menu-toggle");
        
        hamburger.addEventListener("click", function () {
            menu.classList.toggle("active");
        });
    });