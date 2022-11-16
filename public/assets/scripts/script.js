//Ciblage des carousels
const carousels = document.querySelectorAll(".carousel-series");

//Ciblage des cards
const cards = document.querySelectorAll(".carousel-serie");

for (let i = 0; i < carousels.length; i++) {
    for (let j = (0 + (i * 4)); j < ((i * 4) + 4); j++) {
        cards[j].addEventListener("wheel", (event) => {
            event.preventDefault();
            carousels[i].scrollLeft += event.deltaY;
        })
    }
};
