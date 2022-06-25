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
        Schema::create('contrat_annexes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->date('debut');
            $table->date('fin');
            $table->longText('usage')->nullable();
            $table->dateTime('date_acompte')->nullable();
            $table->dateTime('date_solde')->nullable();
            $table->dateTime('date_proforma')->nullable();
            $table->string('attachment', 255)->nullable();
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('personne_id')->constrained('personnes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('annexe_id')->constrained('service_annexes')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('contrat_annexes');
    }
};
