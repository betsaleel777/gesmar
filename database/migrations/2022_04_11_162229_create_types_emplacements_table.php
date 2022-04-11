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
        Schema::create('emplacements', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 255)->unique();
            $table->unsignedMediumInteger('superficie')->default(0);
            $table->unsignedInteger('loyer')->default(0);
            $table->unsignedInteger('pas_porte')->default(0);
            $table->boolean('busy')->default(false);
            $table->boolean('reserved')->default(false);
            $table->foreignId('type_emplacement_id')->constrained('type_emplacements')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('zone_id')->constrained('zones')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('emplacements');
    }
};
