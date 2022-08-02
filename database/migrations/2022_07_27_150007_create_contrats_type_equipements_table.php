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
        Schema::create('contrats_type_equipements', function (Blueprint $table) {
            $table->foreignId('contrat_id')->constrained('contrats')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('type_equipement_id')->constrained('type_equipements')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['contrat_id', 'type_equipement_id'], 'contrat_type_equipement_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contrats_type_equipements');
    }
};
