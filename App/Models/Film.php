<?php

namespace App\Models;

use App\Core\DB\Connection;

class Film extends \App\Core\Model
{
    public function __construct(
        public int $id = 0,
        public ?string $nazov = null,
        public ?string $orgNazov = null,
        public ?string $zaner = null,
        public ?string $krajina = null,
        public ?string $rezia = null,
        public ?string $scenar = null,
        public ?string $hraju = null,
        public ?string $obsah = null,
        public int $pocetHodnoteni = 0,
        public float $hodnotenie = 0,
        public int $pocetHviezd = 0
    )
    {

    }

    static public function setDbColumns()
    {
        return ['id','nazov','orgNazov','zaner','krajina','rezia','scenar','hraju',
            'obsah','pocetHodnoteni','hodnotenie','pocetHviezd'];
    }

    static public function setTableName()
    {
        return "film";
    }

    public function ohodnot($pocet)
    {
        $this->pocetHviezd += $pocet;
        $this->pocetHodnoteni++;
        $this->hodnotenie = (float)($this->pocetHviezd/($this->pocetHodnoteni));
    }

    public function getObrazky(){
        return Obrazok::getAll('film_id = ?',[$this->id]);
    }

    public function getPriemerneHodnotenie() {
        $priemer = $this->pocetHviezd/$this->pocetHodnoteni;
        return $priemer;
    }

    public function getZaujimavosti(){
        return Zaujimavost::getAll('film_id = ?',[$this->id]);
    }
}