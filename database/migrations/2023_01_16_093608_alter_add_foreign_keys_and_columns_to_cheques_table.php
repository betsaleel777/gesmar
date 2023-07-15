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
        Schema::table('cheques', function (Blueprint $table) {
            $table->foreignId('compte_id')->constrained('comptes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('banque_id')->constrained('banques')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cheques', function (Blueprint $table) {
            $table->dropConstrainedForeignId('compte_id');
            $table->dropConstrainedForeignId('banque_id');
        });
    }
};
