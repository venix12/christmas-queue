<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGamemodesToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('osu')->default(0);
            $table->boolean('catch')->default(0);
            $table->boolean('mania')->default(0);
            $table->boolean('taiko')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('osu');
            $table->dropColumn('catch');
            $table->dropColumn('mania');
            $table->dropColumn('taiko');
        });
    }
}
