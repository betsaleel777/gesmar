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
        Schema::create('equipements', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 255);
            $table->string('code', 10);
            $table->unsignedInteger('prix_unitaire');
            $table->unsignedInteger('prix_fixe');
            $table->unsignedInteger('frais_facture');
            $table->unsignedInteger('index');
            $table->foreignId('emplacement_id')->constrained('emplacements')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('type_equipement_id')->constrained('type_equipements')->onDelete('cascade')->onUpdate('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipements');
    }
};
