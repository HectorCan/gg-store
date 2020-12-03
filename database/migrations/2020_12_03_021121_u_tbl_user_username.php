<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UTblUserUsername extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('user')->delete();

        Schema::table('user', function (Blueprint $t) {
            $t->string('username', 20)->unique()->after('name');
        });

        DB::table('user')->insert([
            ['name' => 'Administrator', 'username' => 'admin', 'email' => 'admin@gg.com', 'statusId' => 1, 'password' => Hash::make('123456'), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $t) {
            $t->dropColumn('username');
        });
    }
}
