const carousel = document.querySelectorAll(".carousel-items");



for (let i = 0; i < carousel.length; i++) {
    carousel[i].addEventListener("wheel", (event) => {
        event.preventDefault();
        console.log(event.deltaY)
        carousel[i].scrollLeft += event.deltaY;
    })
};

