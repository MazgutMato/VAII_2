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
}