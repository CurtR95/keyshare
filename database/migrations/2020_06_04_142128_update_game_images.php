<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGameImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->string('image')->default('../images/gamedefault.png')->change();

        DB::update("UPDATE games
                    SET image = '../images/gamedefault.png'
                    WHERE image = 'images/gamedefault.png'
                    ");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->string('image')->default('/images/gamedefault.png')->change();

        DB::update("UPDATE games
                    SET image = 'images/gamedefault.png'
                    WHERE image = '../images/gamedefault.png'
                    ");
        });
    }
}
