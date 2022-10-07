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
        Schema::create('bordereaus', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('commercial_id')->constrained('commercials')->onDelete('cascade')->onUpdate('cascade');
            $table->date('date_attribution')->unique();
            $table->foreign('date_attribution')->references('jour')->on('attribution_emplacements')->onDelete('cascade');
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
        Schema::dropIfExists('bordereaus');
    }
};