var filmId;
function nacitajFilm(id){
    filmId = id;
    fetch('?a=getFilm',{
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'id='+id
    })
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                zmenForm(data)
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
}
function zmenData(data){
    document.getElementById('nazovFilmuP').innerHTML = data.orgNazov;
    document.getElementById('zanerP').innerHTML = data.zaner;
    document.getElementById('krajinaP').innerHTML = data.krajina;
    document.getElementById('reziaP').innerHTML = data.rezia;
    document.getElementById('scenarP').innerHTML = data.scenar;
    document.getElementById('hrajuP').innerHTML = data.hraju;
}
window.onload = function () {
    document.getElementById('upravFilm').onclick = () => {
        let data = new FormData();
        data.append('id',filmId);
        data.append('nazov',document.getElementById('nazovFilmu').value);
        data.append('zaner',document.getElementById('zaner').value);
        data.append('krajina',document.getElementById('krajina').value);
        data.append('rezia',document.getElementById('rezia').value);
        data.append('scenar',document.getElementById('scenar').value);
        data.append('hraju',document.getElementById('hraju').value);
        fetch('?a=setFilm',{
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
}