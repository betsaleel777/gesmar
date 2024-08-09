<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personnes', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 60);
            $table->string('prenom', 255);
            $table->string('code', 10)->unique();
            $table->string('adresse', 255);
            $table->string('contact', 20);
            $table->string('email', 255)->nullable();
            $table->string('ville', 80);
            $table->string('numero_carte', 12);
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('type_personne_id')->nullable()->constrained('type_personnes')->onDelete('cascade')->onUpdate('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personnes');
    }
};
