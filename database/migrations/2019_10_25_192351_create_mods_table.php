<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('mapset_id')->unsigned();
            $table->integer('type')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')
            ->on('users');

            $table->foreign('mapset_id')
                ->references('id')
                ->on('mapsets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mods');
    }
}
