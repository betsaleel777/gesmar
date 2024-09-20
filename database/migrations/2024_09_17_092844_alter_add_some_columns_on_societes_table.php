<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('societes', function (Blueprint $table) {
            $table->string('boite_postale', 150)->nullable();
            $table->unsignedInteger('timbre_loyer')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('societes', function (Blueprint $table) {
            $table->dropColumn('boite_postale');
            $table->dropColumn('timbre_loyer');
        });
    }
};
