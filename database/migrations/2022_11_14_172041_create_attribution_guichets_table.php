<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribution_guichets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caissier_id')->constrained('caissiers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('guichet_id')->constrained('guichets')->onDelete('cascade')->onUpdate('cascade');
            $table->date('date');
            $table->unique(['caissier_id', 'guichet_id', 'date']);
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
        Schema::dropIfExists('attribution_guichets');
    }
};
