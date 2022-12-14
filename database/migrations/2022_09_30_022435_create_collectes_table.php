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
        Schema::create('collectes', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('nombre');
            $table->unsignedInteger('montant');
            $table->foreignId('attribution_id')->constrained('attribution_emplacements')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('collectes');
    }
};
