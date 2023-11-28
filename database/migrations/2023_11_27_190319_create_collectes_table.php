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
            $table->date('jour');
            $table->unsignedSmallInteger('montant');
            $table->foreignId('bordereau_id')->constrained('bordereaux')->cascadeOnDelete();
            $table->foreignId('emplacement_id')->constrained('emplacements')->cascadeOnDelete();
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
