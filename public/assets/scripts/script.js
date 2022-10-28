//Ciblage des carousels
const carousel = document.querySelectorAll(".carousel-items");

//Ciblage des cards
const lastCard = document.querySelectorAll("carousel-item");

//Flag de l'affichage si besoin
const isDisplayedLastCard = false;


for (let i = 0; i < carousel.length; i++) {
    carousel[i].addEventListener("wheel", (event) => {
        event.preventDefault();
        console.log(event.deltaY)
        carousel[i].scrollLeft += event.deltaY;
    })
};



