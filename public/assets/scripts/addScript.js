const choekboxes = document.querySelectorAll(".styleTags");
const maxCheckedBoxes = 2;

for (let i = 0; i < choekboxes.length; i++)
    choekboxes[i].onclick = selectiveCheck;
function selectiveCheck(event) {
    let checkedChecks = document.querySelectorAll(".styleTags:checked");
    if (checkedChecks.length >= maxCheckedBoxes + 1)
        return false;
}

const buttonSearch = document.getElementById("serieSearchButton");

function fetchSeries(serieSearch) {
    axios.get(`https://api.tvmaze.com/search/shows?q=${serieSearch}`)
        .then(function (response) {
            return response.data;
        })
        .then(function (series) {
            //console.log(JSON.stringify(series, null, 2));
            let seriesHtml = `<section class="carouselSerie">
				<ul class="carousel-series">`;
            for (serie of series) {
                seriesHtml += `<li class="carousel-serie">
								<img src="`
                seriesHtml += serie?.show?.image?.original ? `${serie.show.image.original}` : "/assets/images/MY.png";
                seriesHtml += `"/>
                                <div class= "card-content">
								<h3 class="card-title" id=cardContent data-id="${serie?.show?.id}">${serie?.show?.name}</h3>
							</div>
						</li >
                `;
            };
            seriesHtml += `</ul >
			</section > `;
            document.querySelector('.fetchedSeries').innerHTML = seriesHtml;

            const cardContents = document.querySelectorAll('#cardContent');
            for (cardContent of cardContents) {
                cardContent.style.cursor = "pointer";
                cardContent.addEventListener('click', function (event) {
                    fetchOneSerie(event.srcElement.dataset.id);
                });
            }
        });
};



function fetchOneSerie(id) {
    axios.get(`https://api.tvmaze.com/shows/${id}`)
        .then(function (response) {
            return response.data;
        })
        .then(function (completeForm) {
            //console.log(JSON.stringify(completeForm, null, 2));
            let description
            if (completeForm?.summary) {
                description = completeForm.summary.slice(3, -4);
            } else {
                description = "";
            }
            document.getElementById('serieName').setAttribute('value', completeForm?.name);
            document.getElementById('year').setAttribute('value', completeForm?.premiered);
            document.querySelector('#description').innerHTML = `${description}`;
        });
};


buttonSearch.addEventListener("click", function () {
    let serieSearch = document.getElementById("serieSearch").value;
    fetchSeries(serieSearch);
});
