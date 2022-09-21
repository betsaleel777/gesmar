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
        Schema::table('attribution_emplacements', function (Blueprint $table) {
            $table->date('jour')->index();
            $table->unique(['emplacement_id', 'commercial_id', 'jour'], 'attribution_emplacements_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attribution_emplacements', function (Blueprint $table) {
            //
        });
    }
};
