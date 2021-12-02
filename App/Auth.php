<?php

namespace App;

class Auth
{
    const LOGIN = "admin";
    const PASSWORD = "admin123";

    public static function login($login,$password)
    {
        if ($login == self::LOGIN && $password == self::PASSWORD){
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