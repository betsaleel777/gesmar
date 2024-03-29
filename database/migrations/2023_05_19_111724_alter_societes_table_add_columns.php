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
        Schema::table('societes', function (Blueprint $table) {
            $table->string('smartphone', 20);
            $table->string('phone', 20);
            $table->string('email', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('societes', function (Blueprint $table) {
            $table->dropColumn('smartphone', 20);
            $table->dropColumn('phone', 20);
            $table->dropColumn('email', 200);
        });
    }
};
