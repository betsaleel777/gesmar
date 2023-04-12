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
        Schema::create('encaissement_fermeture', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fermeture_id')->constrained('fermetures')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('encaissement_id')->constrained('encaissements')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('encaissement_fermeture');
    }
};
