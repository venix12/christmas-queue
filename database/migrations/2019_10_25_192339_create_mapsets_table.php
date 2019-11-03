<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mapsets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('osu_user_id');
            $table->string('beatmapset_artist');
            $table->string('beatmapset_creator');
            $table->string('beatmapset_title');
            $table->bigInteger('beatmapset_osu_id');
            $table->boolean('approved')->default(0);
            $table->boolean('deleted')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')
            ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mapsets');
    }
}
