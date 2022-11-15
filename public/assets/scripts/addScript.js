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
            console.log(JSON.stringify(series, null, 2));
            let seriesHtml = `<section class="carouselSerie">
				<ul class="carousel-series">`;
            for (serie of series) {
                seriesHtml += `
						<li class="carousel-serie">
								<img src="${serie.show.image.original ? serie.show.image.original : " "}"/>
                                <div class= "card-content">
								<h3 class="card-title">${serie.show.name}</h3>
                                <input type="button" id="completeForm" value="add" onclick="completeForm(${serie.show.id})">
							</div>
						</li >
                `;
            };

            seriesHtml += `</ul >
			</section > `;

            document.querySelector('.fetchedSeries').innerHTML = seriesHtml;
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
            if (completeForm.summary != null) {
                description = completeForm.summary.slice(3, -4);
            } else {
                description = "";
            }
            document.getElementById('serieName').setAttribute('value', completeForm.name);
            document.getElementById('year').setAttribute('value', completeForm.premiered);
            document.querySelector('#description').innerHTML = `${description}`;
        });
};


buttonSearch.addEventListener("click", function () {
    let serieSearch = document.getElementById("serieSearch").value;
    console.log(serieSearch);
    fetchSeries(serieSearch);
})


function completeForm(id) {
    fetchOneSerie(id);
}
