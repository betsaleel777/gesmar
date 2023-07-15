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
        Schema::table('personnes', function (Blueprint $table) {
            $table->string('nom_complet_pere')->nullable();
            $table->string('nom_complet_mere')->nullable();
            $table->string('profession_conjoint')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personnes', function (Blueprint $table) {
            $table->dropColumn('nom_complet_pere')->nullable();
            $table->dropColumn('nom_complet_mere')->nullable();
            $table->dropColumn('profession_conjoint')->nullable();
        });
    }
};
