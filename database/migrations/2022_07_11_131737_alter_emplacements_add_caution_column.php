<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('emplacements', function (Blueprint $table) {
            $table->unsignedInteger('caution')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('emplacements', function (Blueprint $table) {
            $table->unsignedInteger('caution')->default(0);
        });
    }
};
