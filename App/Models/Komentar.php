<?php

namespace App\Models;

use App\Core\DB\Connection;

class Komentar extends \App\Core\Model
{

    public function __construct(
        public int $id = 0,
        public ?string $text = null,
        public ?string $autor = null,
        public int $film_id = 0)
    {
    }

    static public function setDbColumns()
    {
        return ['id','text','autor','film_id'];
    }

    static public function setTableName()
    {
        return 'komentare';
    }
}