<?php

namespace App\Controllers;

use App\Auth;
use App\Core\AControllerBase;
use App\Core\DB\Connection;
use App\Models\Film;
use App\Models\Obrazok;
use App\Models\Zaujimavost;

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
        }

        return $this->html();
    }

    public function pridajObrazok()
    {
        $filmId['filmId'] = $this->request()->getValue('filmId');
        $obrazok = new Obrazok();
        $obrazok->film_id = $filmId['filmId'];
        $obrazok->url = $this->request()->getValue('url');
        $obrazok->save();

        $this->redirect('home','film',$filmId);
    }

    public function formFilm()
    {
        $film = new Film();
        $film->nazov = $this->request()->getValue('nazov');
        $film->orgNazov = $this->request()->getValue('orgNazov');
        $film->zaner = $this->request()->getValue('zaner');
        $film->krajina = $this->request()->getValue('krajina');
        $film->rezia = $this->request()->getValue('rezia');
        $film->scenar = $this->request()->getValue('scenar');
        $film->hraju = $this->request()->getValue('hraju');

        if ($this->request()->getValue('obsah') == "") {
            $this->redirect('home','pridajFilm',['error' => 'Film nebol pridaný, nezadali ste obsah!']);
        } else {
            $film->obsah = $this->request()->getValue('obsah');
        }

        $film->save();
        $this->redirect('home','pridajFilm',['success' => 'Film bol pridaný do databázy, môžeš pridať další.']);
    }

    public function rebricek()
    {
//        $stmt = Connection::connect()->prepare("SELECT * FROM film ORDER BY hodnotenie");
//        $stmt->execute();
//        $filmy = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Film::class);

        $filmy = Film::getAll();
        return $this->html([
            'filmy' => $filmy,
        ]);
    }

    public function film()
    {
        $filmId = $this->request()->getValue('filmId');
        if ($filmId > 0) {
            $film = Film::getOne($filmId);
        }
        return $this->html(
            [
                'film' => $film,
            ]
        );
    }

    public function prihlasenie()
    {
        return $this->html();
    }

    public function addZaujimavost(){
        $filmId['filmId'] = $this->request()->getValue('filmId');
        if ($filmId) {
            $novyZaujimavost = new Zaujimavost();
            $novyZaujimavost->film_id = $filmId['filmId'];
            $novyZaujimavost->autor = $this->request()->getValue('autor');
            $novyZaujimavost->text = $this->request()->getValue('zaujimavost');
            $novyZaujimavost->save();
        }
        $this->redirect('home','film',$filmId);
    }

    public function deleteZaujimavost(){
        $filmId['filmId'] = $this->request()->getValue('filmId');
        $ZaujimavostId = $this->request()->getValue('ZaujimavostId');
        if ($ZaujimavostId > 0) {
            Connection::connect()->prepare('DELETE FROM zaujimavosti WHERE id = ?')->execute([$ZaujimavostId]);
            $this->redirect('home','film',$filmId);
        }
    }

    public function addHviezda(){
        $filmId['filmId'] = $this->request()->getValue('filmId');
        $pocet = $this->request()->getValue('pocetHviezd');
        if ($filmId['filmId'] > 0) {
            $film = Film::getOne($filmId['filmId']);
            $film->ohodnot($pocet);
            $film->save();
            $this->redirect('home','film',$filmId);
        }
    }
}