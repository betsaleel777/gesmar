<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipements', function (Blueprint $table) {
            $table->dateTime('date_occupe')->nullable();
            $table->dateTime('date_abime')->nullable();
            $table->dateTime('date_libre')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipements', function (Blueprint $table) {
            //
        });
    }
};
