<?php


namespace App\Logic\Inventory;

use App\Repositories\Article as ArticleRepo;

class Article
{
    public static function Store($name, $barCode, $status)
    {
        $A = new ArticleRepo();
        $A->name = $name;
        $A->barcode = $barCode;
        $A->statusId = $status;
        $A->save();

        return $A;
    }
}
