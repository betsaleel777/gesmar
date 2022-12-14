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
        Schema::create('attribution_emplacements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commercial_id')->constrained('commercials')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('emplacement_id')->constrained('emplacements')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('attribution_emplacements');
    }
};
