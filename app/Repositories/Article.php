<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';

    public function Stock()
    {
        return $this->hasOne('App\Repositories\Stock', 'articleId', 'id');
    }
}
