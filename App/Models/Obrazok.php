<?php

namespace App\Models;

class Obrazok extends \App\Core\Model
{
    public function __construct(
        public int $id = 0,
        public int $film_id = 0,
        public ?string $url = null)
    {
    }

    static public function setDbColumns()
    {
        return ['id','film_id','url'];
    }

    static public function setTableName()
    {
        return 'obrazok';
    }
}