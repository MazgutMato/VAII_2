class Pouzivatel{
    pridajObrazok(){
        let meno = document.getElementById('meno').value;
        let input = document.querySelector('input#obrazok');
        let subory = input.files;
        let data = new FormData();
        data.append('meno',meno);
        data.append('obrazok',subory[0]);
        if (subory.length === 0) {
            alert("Nezadal si adresu obrazku!");
        } else {
            if (skontrolujObrazok(subory[0])){
                fetch('?c=auth&a=pridajObrazok',{
                    method: 'POST',
                    body: data
                })
                    .then(response => response.json())
                    .then(pouzivatel => {
                        document.getElementById("fotka").src=pouzivatel.obrazok;
                    });
            } else {
                alert("Neakceptovany typ obrazku!");
            }
        }
    }
}
const typyObrazkov = [
    "image/gif",
    "image/jpeg",
    "image/png"
]
function skontrolujObrazok(subor){
    return typyObrazkov.includes(subor.type);
}
window.onload = function () {
    var pouzivatel = new Pouzivatel();
    document.getElementById('pridajObr').onclick = () => {
        pouzivatel.pridajObrazok();
    }
}
function zmazFilm(filmId){
    fetch('?c=auth&a=zmazFilm',{
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'filmId='+filmId
        })
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                document.getElementById('film'+filmId).remove();
                document.getElementById('pocetFilmov').innerHTML -= 1;
            }
        });
}