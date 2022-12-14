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
        Schema::create('service_annexes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10);
            $table->string('nom', 250);
            $table->unsignedInteger('prix');
            $table->longText('description')->nullable();
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade')->onUpdate('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('service_annexes');
    }
};
