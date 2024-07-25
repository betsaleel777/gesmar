<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bordereau_emplacement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bordereau_id')->constrained('bordereaux')->cascadeOnDelete();
            $table->foreignId('emplacement_id')->constrained('emplacements')->cascadeOnDelete();
            $table->unsignedInteger('loyer');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bordereau_emplacement');
    }
};
