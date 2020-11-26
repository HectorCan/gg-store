<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CTblArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $t) {
          $t->increments('id');
          $t->string('name', 100);
          $t->string('barcode', 255);
          $t->unsignedInteger('statusId')->default(1);

          $t->timestamps();
        });

        Schema::create('stocks', function (Blueprint $t) {
          $t->increments('id');
          $t->unsignedInteger('qty')->default(0);
          $t->unsignedInteger('articleId');

          $t->foreign('articleId')->references('id')->on('articles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
        Schema::dropIfExists('articles');
    }
}
