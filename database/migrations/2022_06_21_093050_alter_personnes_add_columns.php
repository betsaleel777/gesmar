<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personnes', function (Blueprint $table) {
            $table->string('nationalite')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('profession')->nullable();
            $table->string('numero_compte')->nullable();
            $table->string('banque')->nullable();
            $table->date('naissance')->nullable();
            $table->string('nom_complet_conjoint')->nullable();
            $table->string('naissance_conjoint')->nullable();
            $table->date('date_mariage')->nullable();
            $table->string('lieu_mariage')->nullable();
            $table->string('regime')->nullable();
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
            $table->string('nationalite')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('profession')->nullable();
            $table->string('numero_compte')->nullable();
            $table->string('banque')->nullable();
            $table->date('naissance')->nullable();
            $table->string('nom_complet_conjoint')->nullable();
            $table->string('naissance_conjoint')->nullable();
            $table->date('date_mariage')->nullable();
            $table->string('lieu_mariage')->nullable();
            $table->string('regime')->nullable();
        });
    }
};
