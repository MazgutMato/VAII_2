var filmId;
function nacitajId(id){
    filmId = id;
}
function nacitajFilm(){
    fetch('?c=movie&a=getFilm',{
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'id='+filmId
    })
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                zmenForm(data)
                document.getElementById('obsah').value = data.obsah;
            } else {
                alert(data.error);
            }
        });
}
function zmenForm(data){
    document.getElementById('nazovFilmu').value = data.orgNazov;
    document.getElementById('zaner').value = data.zaner;
    document.getElementById('krajina').value = data.krajina;
    document.getElementById('rezia').value = data.rezia;
    document.getElementById('scenar').value = data.scenar;
    document.getElementById('hraju').value = data.hraju;
    document.getElementById('premiera').value = data.premiera;
}
function zmenData(data){
    document.getElementById('nazovFilmuP').innerHTML = data.orgNazov;
    document.getElementById('zanerP').innerHTML = data.zaner;
    document.getElementById('krajinaP').innerHTML = data.krajina;
    document.getElementById('reziaP').innerHTML = data.rezia;
    document.getElementById('scenarP').innerHTML = data.scenar;
    document.getElementById('hrajuP').innerHTML = data.hraju;
    document.getElementById('premieraP').innerHTML = data.premiera;
}
function pridajKomentar(komentar){
    let html =
        `<div id="komentar` + komentar.id + `">
        <p class="card-text m-2" id="komentarText` + komentar.id + `">` + komentar.text + ` (` + komentar.autor + `)` + `</p>
        <input class="form-control" type="text" id="komUpraveny`+komentar.id+`" value="`+komentar.text+`">
        <button class="btn btn-secondary mt-2" onClick="updateKomentar(`+komentar.id+`)">Uprav komentar</button>
        <button class="btn btn-secondary mt-2" onClick="deleteKomentar(`+komentar.id+`)">Zmaz komentar</button>
        </div>`
    document.getElementById('komentare').innerHTML += html;
}
function updateKomentar(id){
    let data = new FormData();
    data.append('id',id);
    let text = document.getElementById('komUpraveny'+id).value;
    data.append('text',text);
    fetch('?c=comment&a=updateKomentar',{
        method: 'POST',
        body: data,
    })
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                document.getElementById('komentarText'+id).innerHTML = data.text
                    + " (" + data.autor + ")";
                document.getElementById('komUpraveny'+id).value = data.text;
            } else {
                alert(data.error);
            }
        });
}
function deleteKomentar(id){
    let data = new FormData();
    data.append('id',id);
    fetch('?c=comment&a=deleteKomentar',{
        method: 'POST',
        body: data,
    })
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                document.getElementById('komentar'+id).remove();
            } else {
                alert(data.error);
            }
        });
}
window.onload = function () {
    if (document.getElementById('upravFilm') && document.getElementById('upravObsah')) {
        document.getElementById('upravFilm').onclick = () => {
            let data = new FormData();
            data.append('id',filmId);
            data.append('nazov',document.getElementById('nazovFilmu').value);
            data.append('zaner',document.getElementById('zaner').value);
            data.append('krajina',document.getElementById('krajina').value);
            data.append('rezia',document.getElementById('rezia').value);
            data.append('scenar',document.getElementById('scenar').value);
            data.append('hraju',document.getElementById('hraju').value);
            data.append('premiera',document.getElementById('premiera').value);
            fetch('?c=movie&a=setFilm',{
                method: 'POST',
                body: data,
            })
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        zmenData(data)
                        zmenForm(data)
                    } else {
                        alert(data.error);
                    }
                });
        }
        document.getElementById('upravObsah').onclick = () => {
            let data = new FormData();
            data.append('id',filmId);
            data.append('obsah',document.getElementById('obsah').value);
            fetch('?c=movie&a=setObsah',{
                method: 'POST',
                body: data,
            })
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        document.getElementById('obsahP').innerHTML = data.obsah;
                        document.getElementById('obsah').value = data.obsah;
                    } else {
                        alert(data.error);
                    }
                });
        }
    }
    if ( document.getElementById('odoslatKomentar')) {
        document.getElementById('odoslatKomentar').onclick = () => {
            let data = new FormData();
            data.append('filmId', filmId);
            data.append('komentar', document.getElementById('komentarNovy').value);
            fetch('?c=comment&a=addKomentar', {
                method: 'POST',
                body: data,
            })
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        document.getElementById('komentarNovy').value = "";
                        pridajKomentar(data);
                    } else {
                        alert(data.error);
                    }
                });
        }
    }
}