window.addEventListener("scroll", function () {
    var navbar = document.querySelector(".navbar");
    if (window.scrollY > 0) {
        navbar.classList.add("scrolled", "animated");
    } else {
        navbar.classList.remove("scrolled", "animated");
    }
});