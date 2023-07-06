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
        Schema::create('cabinet', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('dateCreation');
            $table->string('logo')->nullable();
            $table->string('siege')->nullable();
            $table->unsignedBigInteger('nReference')->default(1);
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
        Schema::dropIfExists('cabinet');
    }
};
