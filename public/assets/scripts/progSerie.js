const progressSeasons = document.querySelectorAll("#update-seen-seasons");

for (progressSeason of progressSeasons) {
    progressSeason.addEventListener('change', function (event) {
        event.preventDefault();
        event.stopPropagation();
        const serieId = event.target.dataset.id;
        ajaxRequestSaison(serieId, event.target.value);
    })
}

function ajaxRequestSaison(serie, seen) {
    url = `/etagere/indexAjax?serie=${serie}&seen=${seen}`;
    fetch(url)
        .then(function (response) {
            return response.text()
        })
        .then(function (html) {
            console.log(serie)
            const progressContainer = document.querySelector("[data-progess-container-id='" + serie + "']");
            console.log(progressContainer);
            progressContainer.innerHTML = html;
        })
}
