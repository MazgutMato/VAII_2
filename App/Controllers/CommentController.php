<?php

namespace App\Controllers;

use App\Auth;
use App\Core\DB\Connection;
use App\Core\Responses\Response;
use App\Models\Film;
use App\Models\Komentar;

class CommentController extends AControllerRedirect
{

    public function index()
    {
        return $this->html();
    }

    public function addKomentar(){
        if (!Auth::isLogged()) {
            $param['error'] = "Nie si prihlaseny!";
            return $this->json($param);
        }
        if (isset($_POST['filmId'])) {
            $param['filmId'] = $this->request()->getValue('filmId');
            if ($_POST['komentar'] == ""){
                $param['error'] = "Nebol zadany text komentara!";
                return $this->json($param);
            }
            $novyKomentar = new Komentar();
            $novyKomentar->film_id = $param['filmId'];
            $novyKomentar->autor = Auth::getName();
            $novyKomentar->text = $this->request()->getValue('komentar');
            $novyKomentar->save();
            $komentare = Komentar::getAll();
            return $this->json($komentare[sizeof($komentare) -  1]);
        } else {
            $param['error'] = "Nastala chyba pri pridavani komentara";
            return $this->json($param);
        }
    }
    public function updateKomentar(){
        if (!Auth::isLogged()) {
            $param['error'] = "Nie si prihlaseny!";
            return $this->json($param);
        }
        if (isset($_POST['id'])){
            $komentarId = $this->request()->getValue('id');
        } else {
            $param['error'] = "Nastala chyba pri mazani komentara!";
            return $this->json($param);
        }
        $komentar = Komentar::getOne($komentarId);
        $film = Film::getOne($komentar->film_id);
        if ($komentar) {
            if ($komentar->autor == Auth::getName() || $film->autor == Auth::getName()){
                $komentar->text = $this->request()->getValue('text');
                $komentar->save();
                $param['text'] = $komentar->text;
                $param['autor'] = $komentar->autor;
                return $this->json($param);
            } else {
                $param['error'] = "Nemas pravo upravit tento komentar!";
                return $this->json($param);
            }
        }
        $param['error'] = "Komentar nebol najdeny!";
        return $this->json($param);
    }
    public function deleteKomentar(){
        if (!Auth::isLogged()) {
            $param['error'] = "Nie si prihlaseny!";
            return $this->json($param);
        }
        if (isset($_POST['id'])){
            $komentarId = $this->request()->getValue('id');
        } else {
            $param['error'] = "Nastala chyba pri mazani komentara!";
            return $this->json($param);
        }
        $komentar = Komentar::getOne($komentarId);
        $film = Film::getOne($komentar->film_id);
        if ($komentar) {
            if ($komentar->autor == Auth::getName() || $film->autor == Auth::getName()){
                $komentar->delete();
                $param['success'] = "Komentar bol zmazany!";
                return $this->json($param);
            } else {
                $param['error'] = "Nemas pravo zmazat tento komentar!";
                return $this->json($param);
            }
        }
        $param['error'] = "Komentar nebol najdeny!";
        return $this->json($param);
    }
}