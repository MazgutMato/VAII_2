<?php

namespace App\Controllers;

use App\Auth;
use App\Core\DB\Connection;
use App\Core\Responses\Response;
use App\Models\Film;
use App\Models\Hodnotenie;
use App\Models\Komentar;
use App\Models\Obrazok;
use App\Models\Pouzivatel;

class MovieController extends AControllerRedirect
{
    public function index()
    {
        return $this->html();
    }

    public function premiera(){
        return $this->html(
            [
                'film' => Film::getAll('premiera >= ? ORDER BY premiera',[date("Y/m/d")]),
            ]
        );
    }

    public function pridajFilm()
    {
        if (!Auth::isLogged()) {
            $this->redirect('home');
        } else {
            return $this->html();
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
            $this->redirect('movie','pridajFilm',['error' => 'Film nebol pridaný, zle zadany udaj nazov!']);
            return;
        } else {
            $film->nazov = $this->request()->getValue('nazov');
        }
        if ($this->request()->getValue('orgNazov') == "" || strlen($this->request()->getValue('orgNazov')) > 50) {
            $this->redirect('movie','pridajFilm',['error' => 'Film nebol pridaný, zle zadany udaj orgNazov!']);
            return;
        } else {
            $film->orgNazov = $this->request()->getValue('orgNazov');
        }
        if ($this->request()->getValue('zaner') == "" || strlen($this->request()->getValue('zaner')) > 50) {
            $this->redirect('movie','pridajFilm',['error' => 'Film nebol pridaný, zle zadany udaj zaner!']);
            return;
        } else {
            $film->zaner = $this->request()->getValue('zaner');
        }
        if ($this->request()->getValue('krajina') == "" || strlen($this->request()->getValue('krajina')) > 50) {
            $this->redirect('movie','pridajFilm',['error' => 'Film nebol pridaný, zle zadany krajina!']);
            return;
        } else {
            $film->krajina = $this->request()->getValue('krajina');
        }
        if ($this->request()->getValue('rezia') == "" || strlen($this->request()->getValue('rezia')) > 255) {
            $this->redirect('movie','pridajFilm',['error' => 'Film nebol pridaný, zle zadany udaj rezia!']);
            return;
        } else {
            $film->rezia = $this->request()->getValue('rezia');
        }
        if ($this->request()->getValue('scenar') == "" || strlen($this->request()->getValue('scenar')) > 255) {
            $this->redirect('movie','pridajFilm',['error' => 'Film nebol pridaný, zle zadany udaj scenar!']);
            return;
        } else {
            $film->scenar = $this->request()->getValue('scenar');
        }
        if ($this->request()->getValue('hraju') == "" || strlen($this->request()->getValue('hraju')) > 255) {
            $this->redirect('movie','pridajFilm',['error' => 'Film nebol pridaný, zle zadany udaj hraju!']);
            return;
        } else {
            $film->hraju = $this->request()->getValue('hraju');
        }
        if ($this->request()->getValue('premiera') == "") {
            $this->redirect('movie','pridajFilm',['error' => 'Film nebol pridaný, zle zadany udaj premiera!']);
            return;
        } else {
            $film->premiera = $this->request()->getValue('premiera');
        }
        if (isset($_FILES['file'])){
            $meno = date('Y-m-d-H-m-s_') . $_FILES['file']['name'];
            $path = "obrazky/$meno";
            $typObrazok = strtolower(pathinfo(basename($path), PATHINFO_EXTENSION));
            if ($typObrazok != "jpg" && $typObrazok != "png" && $typObrazok != "jpeg" && $typObrazok != "gif") {
                $this->redirect('movie', 'film', ['error' => 'Film nebol pridaný, nezadali ste spravny typ obrazku!']);
                return;
            }
            if ($_FILES['file']['error'] == UPLOAD_ERR_OK) {
                if (strlen($path) > 255){
                    $this->redirect('movie', 'film', ['error' => 'Film nebol pridaný, meno obrázku je dlhé!']);
                    return;
                }
                move_uploaded_file($_FILES['file']['tmp_name'], $path);
                $film->obrazok = $path;
            } else {
                $this->redirect('movie', 'film', ['error' => 'Film nebol pridaný, nezadali ste spravny typ obrazku!']);
                return;
            }
        } else {
            $this->redirect('movie', 'film', ['error' => 'Film nebol pridaný, nezadali ste obrazok!']);
            return;
        }
        if ($this->request()->getValue('obsah') == "") {
            $this->redirect('movie','pridajFilm',['error' => 'Film nebol pridaný, nezadali ste obsah!']);
        } else {
            $film->obsah = $this->request()->getValue('obsah');
        }
        $film->save();
        $this->redirect('movie','pridajFilm',['success' => 'Film bol pridaný do databázy, môžeš pridať další.']);
    }

    public function zoznam()
    {
        return $this->html();
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

    public function zmazFilm(){
        if (!Auth::isLogged()) {
            $this->redirect('home');
            return;
        }
        if (isset($_POST['filmId'])){
            $film = Film::getOne($_POST['filmId']);
            $film->zmaz();
            $this->redirect('home','index',['success' => 'Film bol uspesne vymazany!']);
        } else {
            $this->redirect('home','index',['error' => 'Film sa nepodarilo vymazat!']);
        }
    }

    public function getFilmy(){
        $filmy = Film::getAll();
        return $this->json($filmy);
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
                if (!strtotime($_POST['premiera'])){
                    $data['error'] = "Chyba pri zadavani premiera!";
                    return $this->json($data);
                }
                $film->premiera = $_POST['premiera'];
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

    public function setObsah(){
        if (isset($_POST['id'])){
            $film = Film::getOne($_POST['id']);
            if ($film && $film->autor == Auth::getName()) {
                if ($_POST['obsah'] == ""){
                    $data['error'] = "Chyba pri zadani obsahu!";
                    return $this->json($data);
                }
                $film->obsah = $_POST['obsah'];
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