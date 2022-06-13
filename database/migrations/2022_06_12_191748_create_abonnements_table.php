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
        Schema::create('abonnements', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->unsignedInteger('index_depart');
            $table->unsignedInteger('index_fin')->nullable();
            $table->dateTime('date_resiliation')->nullable();
            $table->foreignId('equipement_id')->constrained('equipements')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('emplacement_id')->constrained('emplacements')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('abonnements');
    }
};
