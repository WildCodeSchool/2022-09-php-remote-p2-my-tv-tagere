const favLinks = document.querySelectorAll("a[data-add-to-fav]");

for (link of favLinks) {
    link.addEventListener('click', function (event) {
        event.preventDefault();
        event.stopPropagation();
        const serieId = event.target.dataset.addToFav;
        ajaxRequest(serieId);
    })
}

function ajaxRequest(serieId) {
    fetch('/series/addOrDeleteToUserAjax?id=' + serieId)
        .then(function (response) {
            return response.json()
        })
        .then(function (json) {
            const images = document.querySelectorAll("a[data-add-to-fav='" + serieId + "'] > img")
            for (image of images) {
                if (json.action === 'added') {
                    image.setAttribute("src", "/assets/images/fav.svg");
                }
                if (json.action === 'deleted') {
                    image.setAttribute("src", "/assets/images/not_fav.svg");
                }
            }
        })
}
