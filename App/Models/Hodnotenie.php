<?php

namespace App\Models;

class Hodnotenie extends \App\Core\Model
{
    public function __construct(
        public int $id = 0,
        public  int $film_id = 0,
        public ?string $pouzivatel_id = null
    )
    {
    }

    static public function setDbColumns()
    {
        return ['id','film_id','pouzivatel_id'];
    }

    static public function setTableName()
    {
        return 'hodnotenia';
    }
}