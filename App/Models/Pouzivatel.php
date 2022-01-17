<?php

namespace App\Models;

class Pouzivatel extends \App\Core\Model
{
    public function __construct(
        public int $id = 0,
        public ?string $meno = null,
        public ?string $heslo = null,
        public ?string $datumReg = null,
        public ?string $obrazok = null
    )
    {
    }

    static public function setDbColumns()
    {
        return ['id','meno','heslo','datumReg','obrazok'];
    }

    static public function setTableName()
    {
        return 'pouzivatelia';
    }

    public function getFilmy(){
        return Film::getAll('autor = ?',[$this->meno]);
    }
}