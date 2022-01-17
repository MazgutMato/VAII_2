<?php

namespace App\Controllers;

use App\Auth;
use App\Core\DB\Connection;
use App\Core\Responses\Response;
use App\Models\Film;
use App\Models\Obrazok;
use App\Models\Pouzivatel;

class AuthController extends AControllerRedirect
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        // TODO: Implement index() method.
    }

    public function prihlasenie() {
        if (Auth::isLogged()){
            $this->redirect('home');
        } else {
            return $this->html(
                [
                    'error' => $this->request()->getValue('error'),
                    'success' => $this->request()->getValue('success')
                ]
            );
        }
    }

    public function registracia() {
        if (Auth::isLogged()){
            $this->redirect('home');
        } else {
            return $this->html(
                [
                    'error' => $this->request()->getValue('error')
                ]
            );
        }
    }

    public function uzivatel() {
        if (!Auth::isLogged()){
            $this->redirect('home');
        } else {
            $uzivatel = Pouzivatel::getAll('meno = ?',[Auth::getName()]);
            $filmy = $uzivatel[0]->getFilmy();
            return $this->html(
                [
                    'pouzivatel' => $uzivatel[0],
                    'filmy' => $filmy
                ]
            );
        }
    }

    public function register(){
        $login = $this->request()->getValue('login');
        $password1 = $this->request()->getValue('password1');
        $password2 = $this->request()->getValue('password2');
        if (strlen($login) < 3 || strlen($login) > 255){
            $this->redirect('auth','registracia',['error' => 'Chyba pri zadávaní loginu!']);
            return;
        }
        if (strlen($password1) < 5 || strlen($password1) > 255 || strcmp($password1,$password2) != 0){
            $this->redirect('auth','registracia',['error' => 'Chyba pri zadávaní hesla!']);
            return;
        }
        if (Pouzivatel::getAll('meno = ?',[$login])){
            $this->redirect('auth','registracia',['error' => 'Používateľ so zadaným loginom už existuje!']);
            return;
        }
        $pouzivatel = new Pouzivatel();
        $pouzivatel->meno = $login;
        $pouzivatel->datumReg = date('Y-m-d');
        $hash = password_hash($password1, PASSWORD_DEFAULT);
        $pouzivatel->heslo = $hash;
        $pouzivatel->obrazok = "obrazky/chyba.jpg";
        $pouzivatel->save();
        $this->redirect('auth','prihlasenie',['success' => 'Úspešne ste sa registrovali, možete sa prihlásiť!']);
    }

    public function login()
    {
        $login = $this->request()->getValue('login');
        $password = $this->request()->getValue('password');

        $logged = Auth::login($login,$password);

        if ($logged) {
            $this->redirect('home');
        } else {
            $this->redirect('auth','prihlasenie',['error' => 'Nesprávne meno alebo heslo!']);
        }
    }

    public function logout()
    {
        Auth::logout();
        $this->redirect('home');
    }

    public function pridajObrazok(){
        if (isset($_POST['meno']) && isset($_FILES['obrazok'])){
            $meno = $_POST['meno'];
            $adresa = $_FILES['obrazok']['tmp_name'];
            $pouzivatel = Pouzivatel::getAll('meno = ?',[$meno]);
            $nazov = $_FILES['obrazok']['name'];
            $path = "obrazky/$meno-$nazov";
            if ($pouzivatel) {
                if ($pouzivatel[0]->obrazok != "obrazky/chyba.jpg"){
                    unlink($pouzivatel[0]->obrazok);
                }
                move_uploaded_file($adresa,$path);
                $pouzivatel[0]->obrazok = $path;
                $pouzivatel[0]->save();
                return $this->json($pouzivatel[0]);
            }
        }
    }
    public function zmazFilm(){
        if (isset($_POST['filmId'])) {
            $filmId = $_POST['filmId'];
            $film = Film::getOne($filmId);
            if ($film->autor != Auth::getName()){
                $data['error'] = 'Nemate opravnenie zmazat film!';
                return $this->json($data);
            } else {
                unlink($film->obrazok);
                $obrazoky = Obrazok::getAll('film_id = ?', [$this->request()->getValue('filmId')]);
                foreach ($obrazoky as $obrazok) {
                    unlink($obrazok->obrazok);
                }
                Connection::connect()->prepare('DELETE FROM obrazok WHERE film_id = ?')->execute([$filmId]);
                Connection::connect()->prepare('DELETE FROM komentare WHERE film_id = ?')->execute([$filmId]);
                Connection::connect()->prepare('DELETE FROM hodnotenia WHERE film_id = ?')->execute([$filmId]);
                Connection::connect()->prepare('DELETE FROM film WHERE id = ?')->execute([$filmId]);
                $data['succes'] = 'Film bol vymazany!';
                return $this->json($data);
            }
        }
    }
}