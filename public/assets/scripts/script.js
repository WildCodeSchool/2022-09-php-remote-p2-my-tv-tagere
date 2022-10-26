const carousel = document.querySelector(".carouselSerie");

carousel.addEventListener("wheel", (event) => {

    event.preventDefault();
    //console.log(event.deltaY);
    /*
    carousel.scrollBy({
        top:0,
        left: event.deltaY,
        behavior: 'smooth',
    });
    */

   console.log(event.deltaY)
   carousel.scrollLeft += event.deltaY;
});

//prompt("badaboum");