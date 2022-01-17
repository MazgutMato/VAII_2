class Zoznam_filmov {
    utriedene;
    zoznamFilmov = [];
    constructor() {
        fetch('?a=getFilmy')
            .then(response => response.json())
            .then(filmy => {
                this.utriedene = 'id';
                for (let film of filmy) {
                    this.zoznamFilmov.push(film);
                }
                this.vypis(this.zoznamFilmov);
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
                                        film.obrazok + `" class="img-news"></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="?c=home&a=film&filmId=` + film.id +
                                        `" class="odkaz">` +
                                        film.nazov + `</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="odkaz">`+ precise(film.hodnotenie) + ` <i class="bi bi-star"></i></td>
                                </tr>
                                <tr>
                                    <td class="odkaz" onmouseleave="zobrazObr(`+film.id+`)" onmouseover="zobrazObsah(`+film.id+`)">Viac info</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>`
        }
        document.getElementById("film").innerHTML = html;
    }
    utried(podla){
        if (this.utriedene == null || this.utriedene != podla) {
            this.zoznamFilmov.sort(function (a, b) {
                return String(a[podla]).localeCompare(String(b[podla]));
            });
            this.utriedene = podla;
        } else {
            this.zoznamFilmov.sort(function (a, b) {
                return String(b[podla]).localeCompare(String(a[podla]));
            });
            this.utriedene = null;
        }
        this.vypis(this.zoznamFilmov);
    }
    najdiFilmy(){
        let nazovFilmu = document.getElementById('nazovFilmu').value.toLowerCase();
        var filter = [];
        fetch('?a=getFilmy')
            .then(response => response.json())
            .then(filmy => {
                for (let film of filmy) {
                    let nazov = film.nazov.toLowerCase();
                    if (nazov.includes(nazovFilmu)) {
                        filter.push(film);
                    }
                }
                this.zoznamFilmov = filter;
                this.vypis(this.zoznamFilmov);
            });
    }
}
function precise(x) {
    return Number.parseFloat(x).toPrecision(3);
}
var film = new Zoznam_filmov();

window.onload = function () {
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
    let obsah;
    for (let data of film.zoznamFilmov) {
            if (id == data.id){
                obsah = data.obsah;
            }
    }
    document.getElementById('obrazok'+id).innerHTML = obsah.slice(0,220)+"...";
}
function zobrazObr(id){
    let obrazok;
    for (let data of film.zoznamFilmov) {
        if (id == data.id){
            obrazok = data.obrazok;
        }
    }
    let html = ""
    html += `<a href="?c=home&a=film&filmId=` + id + `"><img src="` +
                                        obrazok + `" class="img-news"></a>`;
    document.getElementById('obrazok'+id).innerHTML = html;
}