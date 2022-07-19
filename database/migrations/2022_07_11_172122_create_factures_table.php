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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->string('periode', 10)->nullable();
            $table->unsignedTinyInteger('avance')->nullable();
            $table->unsignedTinyInteger('caution')->nullable();
            $table->unsignedInteger('pas_porte')->nullable();
            $table->dateTime('date_facture')->nullable();
            $table->dateTime('date_soldee')->nullable();
            $table->foreignId('annexe_id')->nullable()->constrained('service_annexes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('equipement_id')->nullable()->constrained('equipements')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('contrat_id')->constrained('contrats')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['contrat_id', 'annexe_id']);
            $table->unsignedInteger('index_depart')->nullable();
            $table->unsignedInteger('index_fin')->nullable();
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
        Schema::dropIfExists('factures');
    }
};
