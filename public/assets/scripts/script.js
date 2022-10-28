//Ciblage des carousels
const carousels = document.querySelectorAll(".carousel-series");

//Ciblage des cards
const cards = document.querySelectorAll(".carousel-serie");

/*
for (let i = 0; i < carousels.length; i++) {
    for (let j = 0; j < 4; j++) {
        cards[j].addEventListener("wheel", (event) => {
            event.preventDefault();
            console.log(event.deltaY)
            carousels[i].scrollLeft += event.deltaY;
        })
    }
};
*/


for (let i = 0; i < carousels.length; i++) {
    carousels.addEventListener("wheel", (event) => {
        event.preventDefault();
        console.log(event.deltaY)
        carousels[i].scrollLeft += event.deltaY;
    });
};
