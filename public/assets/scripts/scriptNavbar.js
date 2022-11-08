const navbar = document.querySelector("nav");

    if (document.documentElement.scrollTop > 25) {
        navbar.classList.add("scrolled");
    }
document.addEventListener('scroll', function () {
    if (document.documentElement.scrollTop > 25) {
        navbar.classList.add("scrolled");
    }
    if (document.documentElement.scrollTop < 25) {
        navbar.classList.remove("scrolled");
    }
});