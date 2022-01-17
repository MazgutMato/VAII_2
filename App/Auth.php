<?php

namespace App;

use App\Models\Pouzivatel;

class Auth
{

    public static function login($login,$password)
    {
        $pouzivatel = Pouzivatel::getAll('meno = ?',[$login]);
        if ($pouzivatel[0] && password_verify($password,$pouzivatel[0]->heslo)){
            $_SESSION["name"] = $login;
            return true;
        } else {
            return false;
        }
    }

    public static function isLogged(){
        return isset($_SESSION["name"]);
    }

    public static function getName()
    {
        return (self::isLogged() ? $_SESSION["name"] : "");
    }

    public static function logout()
    {
        unset($_SESSION['name']);
        session_destroy();
    }
}