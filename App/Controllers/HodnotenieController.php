<?php

namespace App\Controllers;

use App\Auth;
use App\Core\Responses\Response;
use App\Models\Film;
use App\Models\Hodnotenie;
use App\Models\Pouzivatel;

class HodnotenieController extends AControllerRedirect
{

    public function index()
    {
        // TODO: Implement index() method.
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
            $this->redirect('movie','film',$param);
            return;
        }
        $pouzivatel = Pouzivatel::getAll('meno = ?',[Auth::getName()]);
        if (Hodnotenie::getAll('film_id = ? AND pouzivatel_id = ?',[$param['filmId'],$pouzivatel[0]->id])){
            $param['error'] = 'Každý film môžete ohodnotiť iba raz!';
            $this->redirect('movie', 'film', $param);
            return;
        }
        $film = Film::getOne($param['filmId']);
        if ($film) {
            $film->ohodnot($pocet);
            $film->save();
            $param['success'] = 'Hodnotenie prebehlo úspešne!';
            $this->redirect('movie', 'film', $param);
        } else {
            $param['error'] = 'Nastala chyba!';
            $this->redirect('movie', 'film', $param);
        }
        $hodnotenie = new Hodnotenie();
        $hodnotenie->film_id = $param['filmId'];
        $hodnotenie->pouzivatel_id = $pouzivatel[0]->id;
        $hodnotenie->save();
    }
}