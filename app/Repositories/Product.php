<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table="products";
    protected $fillable=["id","name","stock","price"];
    
}
