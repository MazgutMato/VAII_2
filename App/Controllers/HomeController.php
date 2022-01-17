<?php

namespace App\Controllers;

use App\Auth;
use App\Core\AControllerBase;
use App\Core\DB\Connection;
use App\Models\Film;
use App\Models\Hodnotenie;
use App\Models\Obrazok;
use App\Models\Komentar;
use App\Models\Pouzivatel;
use PDO;

/**
 * Class HomeController
 * Example of simple controller
 * @package App\Controllers
 */
class HomeController extends AControllerRedirect
{

    public function index()
    {
        $filmy = Film::getAll();
        return $this->html(
            [
                'filmy' => $filmy,
            ]);
    }

    public function pridajFilm()
    {
        if (!Auth::isLogged()) {
            $this->redirect('home');
        } else {
            return $this->html();
        }
    }

    public function pridajObrazok()
    {
        if (!Auth::isLogged()) {
            $this->redirect('home');
            return;
        }
        $param['filmId'] = $this->request()->getValue('filmId');
        if (isset($_FILES['file'])) {
            $meno = date('Y-m-d-H-m-s_') . $_FILES['file']['name'];
            $path = "obrazky/$meno";
            $typObrazok = strtolower(pathinfo(basename($path), PATHINFO_EXTENSION));
            if ($typObrazok != "jpg" && $typObrazok != "png" && $typObrazok != "jpeg" && $typObrazok != "gif") {
                $param['error'] = "Mozete pridat len obrazok typu: JPG, JPEG, PNG & GIF!";
                $this->redirect('home', 'film', $param);
                return;
            }
            if ($_FILES['file']['error'] == UPLOAD_ERR_OK) {
                move_uploaded_file($_FILES['file']['tmp_name'], $path);

                $obrazok = new Obrazok();
                $obrazok->film_id = $param['filmId'];
                $obrazok->obrazok = $path;
                $obrazok->save();
                $param['success'] = "Obrazok bol uspesne pridany!";
                $this->redirect('home', 'film', $param);
            } else {
                $param['error'] = "Nepodarilo sa pridat obrazok!";
                $this->redirect('home', 'film', $param);
            }
        } else {
            $param['error'] = "Nepodarilo sa pridat obrazok!";
            $this->redirect('home', 'film', $param);
        }
    }

    public function formFilm()
    {
        if (!Auth::isLogged()) {
            $this->redirect('home');
            return;
        }
        $film = new Film();
        $film->autor = Auth::getName();
        if ($this->request()->getValue('nazov') == "" || strlen($this->request()->getValue('nazov')) > 50) {
            $this->redirect('home','pridajFilm',['error' => 'Film nebol pridaný, zle zadany udaj nazov!']);
            return;
        } else {
            $film->nazov = $this->request()->getValue('nazov');
        }
        if ($this->request()->getValue('orgNazov') == "" || strlen($this->request()->getValue('orgNazov')) > 50) {
            $this->redirect('home','pridajFilm',['error' => 'Film nebol pridaný, zle zadany udaj orgNazov!']);
            return;
        } else {
            $film->orgNazov = $this->request()->getValue('orgNazov');
        }
        if ($this->request()->getValue('zaner') == "" || strlen($this->request()->getValue('zaner')) > 50) {
            $this->redirect('home','pridajFilm',['error' => 'Film nebol pridaný, zle zadany udaj zaner!']);
            return;
        } else {
            $film->zaner = $this->request()->getValue('zaner');
        }
        if ($this->request()->getValue('krajina') == "" || strlen($this->request()->getValue('krajina')) > 50) {
            $this->redirect('home','pridajFilm',['error' => 'Film nebol pridaný, zle zadany krajina!']);
            return;
        } else {
            $film->krajina = $this->request()->getValue('krajina');
        }
        if ($this->request()->getValue('rezia') == "" || strlen($this->request()->getValue('rezia')) > 255) {
            $this->redirect('home','pridajFilm',['error' => 'Film nebol pridaný, zle zadany udaj rezia!']);
            return;
        } else {
            $film->rezia = $this->request()->getValue('rezia');
        }
        if ($this->request()->getValue('scenar') == "" || strlen($this->request()->getValue('scenar')) > 255) {
            $this->redirect('home','pridajFilm',['error' => 'Film nebol pridaný, zle zadany udaj scenar!']);
            return;
        } else {
            $film->scenar = $this->request()->getValue('scenar');
        }
        if ($this->request()->getValue('hraju') == "" || strlen($this->request()->getValue('hraju')) > 255) {
            $this->redirect('home','pridajFilm',['error' => 'Film nebol pridaný, zle zadany udaj hraju!']);
            return;
        } else {
            $film->hraju = $this->request()->getValue('hraju');
        }
        if (isset($_FILES['file'])){
            $meno = date('Y-m-d-H-m-s_') . $_FILES['file']['name'];
            $path = "obrazky/$meno";
            $typObrazok = strtolower(pathinfo(basename($path), PATHINFO_EXTENSION));
            if ($typObrazok != "jpg" && $typObrazok != "png" && $typObrazok != "jpeg" && $typObrazok != "gif") {
                $this->redirect('home', 'film', ['error' => 'Film nebol pridaný, nezadali ste spravny typ obrazku!']);
                return;
            }
            if ($_FILES['file']['error'] == UPLOAD_ERR_OK) {
                move_uploaded_file($_FILES['file']['tmp_name'], $path);
                $film->obrazok = $path;
            } else {
                $this->redirect('home', 'film', ['error' => 'Film nebol pridaný, nezadali ste spravny typ obrazku!']);
                return;
            }
        } else {
            $this->redirect('home', 'film', ['error' => 'Film nebol pridaný, nezadali ste obrazok!']);
            return;
        }
        if ($this->request()->getValue('obsah') == "") {
            $this->redirect('home','pridajFilm',['error' => 'Film nebol pridaný, nezadali ste obsah!']);
        } else {
            $film->obsah = $this->request()->getValue('obsah');
        }
        $film->save();
        $this->redirect('home','pridajFilm',['success' => 'Film bol pridaný do databázy, môžeš pridať další.']);
    }

    public function zoznam()
    {
        $stmt = Connection::connect()->prepare("SELECT * FROM film ORDER BY nazov");
        $stmt->execute([]);
        $filmy = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Film::class);
        return $this->html([
            'filmy' => $filmy,
        ]);
    }

    public function film()
    {
        if (isset($_GET['filmId'])) {
            $filmId = $this->request()->getValue('filmId');
            $film = Film::getOne($filmId);
        } else {
            $this->redirect('home');
        }
        if ($film){
            return $this->html(
                [
                    'film' => $film,
                ]
            );
        } else {
            $this->redirect('home');
        }
    }

    public function prihlasenie()
    {
        if (Auth::isLogged()) {
            $this->redirect('home');
        } else {
            return $this->html();
        }
    }

    public function addKomentar(){
        if (!Auth::isLogged()) {
            $this->redirect('home');
            return;
        }
        if (isset($_POST['filmId'])) {
            $param['filmId'] = $this->request()->getValue('filmId');
            if ($_POST['komentar'] == ""){
                $param['error'] = "Nebol zadany text zaujumavosti!";
                $this->redirect('home','film',$param);
                return;
            }
            if ($_POST['autor'] == ""){
                $param['error'] = "Pre pridanie zaujumavosti musite byt prihlaseny!";
                $this->redirect('home','film',$param);
                return;
            }
            $novyKomentar = new Komentar();
            $novyKomentar->film_id = $param['filmId'];
            $novyKomentar->autor = $this->request()->getValue('autor');
            $novyKomentar->text = $this->request()->getValue('komentar');
            $novyKomentar->save();
        }
        $param['success'] = "Komentar bola úspešne pridaná!";
        $this->redirect('home','film',$param);
    }

    public function deleteKomentar(){
        if (!Auth::isLogged()) {
            $this->redirect('home');
            return;
        }
        if (isset($_POST['filmId'])){
            $param['filmId'] = $this->request()->getValue('filmId');
        } else {
            $this->redirect('home');
            return;
        }
        if (isset($_POST['KomentarId']) && $_POST['KomentarId'] > 0){
            $komentarId = $this->request()->getValue('KomentarId');
        } else {
            $this->redirect('home');
            return;
        }
        Connection::connect()->prepare('DELETE FROM komentare WHERE id = ?')->execute([$komentarId]);
        $this->redirect('home', 'film', $param);
    }

    public function addHviezda(){
        if (isset($_POST['filmId'])){
            $param['filmId'] = $this->request()->getValue('filmId');
        } else {
            $this->redirect('home');
            return;
        }
        if (isset($_POST['pocetHviezd'])){
            $pocet = $this->request()->getValue('pocetHviezd');
        } else {
            $this->redirect('home');
            return;
        }
        if (!Auth::isLogged()) {
            $param['error'] = 'Ak chceš film ohodnotiť, musíš byť prihlásený!';
            $this->redirect('home','film',$param);
            return;
        }
        $pouzivatel = Pouzivatel::getAll('meno = ?',[Auth::getName()]);
        if (Hodnotenie::getAll('film_id = ? AND pouzivatel_id = ?',[$param['filmId'],$pouzivatel[0]->id])){
            $param['error'] = 'Každý film môžete ohodnotiť iba raz!';
            $this->redirect('home', 'film', $param);
            return;
        }
        $film = Film::getOne($param['filmId']);
        if ($film) {
            $film->ohodnot($pocet);
            $film->save();
            $param['success'] = 'Hodnotenie prebehlo úspešne!';
            $this->redirect('home', 'film', $param);
        } else {
            $param['error'] = 'Nastala chyba!';
            $this->redirect('home', 'film', $param);
        }
        $hodnotenie = new Hodnotenie();
        $hodnotenie->film_id = $param['filmId'];
        $hodnotenie->pouzivatel_id = $pouzivatel[0]->id;
        $hodnotenie->save();
    }

    public function zmazObrazok(){
        if (!Auth::isLogged()) {
            $this->redirect('home');
            return;
        }
        if (isset($_POST['obrazokId']) && isset($_POST['filmId'])){
            $param['filmId'] = $this->request()->getValue('filmId');
            $obrazok = Obrazok::getOne($this->request()->getValue('obrazokId'));
            unlink($obrazok->obrazok);
            Connection::connect()->prepare('DELETE FROM obrazok WHERE id = ?')->execute([
                $this->request()->getValue('obrazokId')]);
            $param['success'] = "Obrazok bol uspesne odstraneny!";
            $this->redirect('home','film',$param);
        } else {
            $this->redirect('home');
        }
    }

    public function zmazFilm(){
        if (!Auth::isLogged()) {
            $this->redirect('home');
            return;
        }
        if (isset($_POST['filmId'])){
            $film = Film::getOne($_POST['filmId']);
            unlink($film->obrazok);
            $obrazoky = Obrazok::getAll('film_id = ?',[$this->request()->getValue('filmId')]);
            foreach ($obrazoky as $obrazok) {
                unlink($obrazok->obrazok);
            }
            Connection::connect()->prepare('DELETE FROM obrazok WHERE film_id = ?')->execute([
                $this->request()->getValue('filmId')]);
            Connection::connect()->prepare('DELETE FROM hodnotenia WHERE film_id = ?')->execute([
                $this->request()->getValue('filmId')]);
            Connection::connect()->prepare('DELETE FROM komentare WHERE film_id = ?')->execute([
                $this->request()->getValue('filmId')]);
            Connection::connect()->prepare('DELETE FROM film WHERE id = ?')->execute([
                $this->request()->getValue('filmId')]);
            $this->redirect('home','zoznam',['success' => 'Film bol uspesne vymazany!']);
        } else {
            $this->redirect('home','zoznam',['error' => 'Film sa nepodarilo vymazat!']);
        }
    }
    public function getFilmy(){
        $filmy = Film::getAll();
        return $this->json($filmy);
    }
    public function getObrazok()
    {
        Pouzivatel::getAll();
    }
    public function getFilm(){
        if (isset($_POST['id'])){
            $film = Film::getOne($_POST['id']);
            if ($film && $film->autor == Auth::getName()) {
                return $this->json($film);
            } else {
                $data['error'] = "Nastala chyba!";
                return $this->json($data);
            }
        } else {
            $data['error'] = "Nastala chyba!";
            return $this->json($data);
        }
    }
    public function setFilm(){
        if (isset($_POST['id'])){
            $film = Film::getOne($_POST['id']);
            if ($film && $film->autor == Auth::getName()) {
                if ($_POST['nazov'] == "" || strlen($_POST['nazov']) > 50){
                    $data['error'] = "Chyba pri zadani org. nazovu!";
                    return $this->json($data);
                }
                $film->orgNazov = $_POST['nazov'];
                if ($_POST['zaner'] == "" || strlen($_POST['zaner']) > 50){
                    $data['error'] = "Chyba pri zadani zaneru!";
                    return $this->json($data);
                }
                $film->zaner = $_POST['zaner'];
                if ($_POST['krajina'] == "" || strlen($_POST['krajina']) > 50){
                    $data['error'] = "Chyba pri zadani krajiny!";
                    return $this->json($data);
                }
                $film->krajina = $_POST['krajina'];
                if ($_POST['rezia'] == "" || strlen($_POST['rezia']) > 255){
                    $data['error'] = "Chyba pri zadani rezie!";
                    return $this->json($data);
                }
                $film->rezia = $_POST['rezia'];
                if ($_POST['scenar'] == "" || strlen($_POST['scenar']) > 255){
                    $data['error'] = "Chyba pri zadani scenaru!";
                    return $this->json($data);
                }
                $film->scenar = $_POST['scenar'];
                if ($_POST['hraju'] == "" || strlen($_POST['hraju']) > 255){
                    $data['error'] = "Chyba pri zadavani hraju!";
                    return $this->json($data);
                }
                $film->hraju = $_POST['hraju'];
                $film->save();
                return $this->json($film);
            } else {
                $data['error'] = "Nastala chyba!";
                return $this->json($data);
            }
        } else {
            $data['error'] = "Nastala chyba!";
            return $this->json($data);
        }
    }
}