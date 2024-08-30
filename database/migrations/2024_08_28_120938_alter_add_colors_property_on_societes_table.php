<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('societes', function (Blueprint $table) {
            $table->string('primaire');
            $table->string('secondaire');
        });
    }

    public function down()
    {
        Schema::table('societes', function (Blueprint $table) {
            $table->dropColumn('primaire');
            $table->dropColumn('secondaire');
        });
    }
};
