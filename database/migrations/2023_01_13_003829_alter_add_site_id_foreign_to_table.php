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
        Schema::table('banques', function (Blueprint $table) {
            $table->foreignId('site_id')->constrained('sites')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banques', function (Blueprint $table) {
            $table->foreignId('site_id')->constrained('sites')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }
};
