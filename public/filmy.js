class Filmy {
    utriedene;
    zoznamFilmov = [];
    constructor() {
        fetch('?a=getFilmy')
            .then(response => response.json())
            .then(data => {
                this.vypis(data);
            });
    }
    vypis(filmy){
        let html = "";
        for (let film of filmy) {
            html += `<div class="col-12 col-lg-4">
                            <table class="table tabulka">
                            <tbody>
                            <tr style="height:250px">
                                <td class="text-light align-middle" id="obrazok`+film.id+`">
                                <a href="?c=home&a=film&filmId=` + film.id + `"><img src="` +
                film.obrazok + `" class="img-news"></a></td></tr>
                                <tr><td><a href="?c=home&a=film&filmId=` + film.id +
                `" class="odkaz">` +
                film.nazov + `</a></td>
                            </tr>
                            <tr><td class="odkaz">`+ precise(film.hodnotenie) + ` <i class="bi bi-star"></i></td></tr>
                            <tr><td class="odkaz" id="obsah" onmouseover="zobrazObsah(`+film.id+`)" 
                            onmouseout="zobrazObr(`+film.id+`)">Viac info</td></tr>
                            </tbody>
                            </table>
                        </div>`
        }
        document.getElementById("film").innerHTML = html;
    }
    utried(podla){
        fetch('?a=getFilmy')
            .then(response => response.json())
            .then(data => {
                if (this.utriedene == null || this.utriedene != podla) {
                    data.sort(function (a, b) {
                        return String(a[podla]).localeCompare(String(b[podla]));
                    });
                    this.utriedene = podla;
                } else {
                    data.sort(function (a, b) {
                        return String(b[podla]).localeCompare(String(a[podla]));
                    });
                    this.utriedene = null;
                }
                this.vypis(data);
            });
    }
    najdiFilmy(){
        let nazovFilmu = document.getElementById('nazovFilmu').value.toLowerCase();
        fetch('?a=getFilmy')
            .then(response => response.json())
            .then(filmy => {
                var filter = [];
                for (let film of filmy) {
                    let nazov = film.nazov.toLowerCase();
                    if (nazov.includes(nazovFilmu)){
                        filter.push(film);
                        this.zoznamFilmov.push(film);
                    }
                }
                this.vypis(filter);
            });
    }
}
function precise(x) {
    return Number.parseFloat(x).toPrecision(3);
}
window.onload = function () {
    var film = new Filmy();
    document.getElementById("nazov").onclick = () => {
        film.utried('nazov')
    }
    document.getElementById("hodnotenie").onclick = () => {
        film.utried('hodnotenie')
    }
    document.getElementById("datum").onclick = () => {
        film.utried('id')
    }
    document.getElementById("vyhladaj").onclick = () => {
        film.najdiFilmy();
    }
}
function zobrazObsah(id){
    fetch('?a=getFilm', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'id='+id
    })
        .then(response => response.json())
        .then(film => {
            document.getElementById('obrazok'+id).innerHTML = film.obsah.slice(0,220)+"...";
        });
}
function zobrazObr(id){
    fetch('?a=getFilm', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'id='+id
    })
        .then(response => response.json())
        .then(film => {
            document.getElementById('obrazok'+id).innerHTML =
                `<a href="?c=home&a=film&filmId=` + film.id +
                `"><img src="` + film.obrazok + `" class="img-news"></a>`
        });
}