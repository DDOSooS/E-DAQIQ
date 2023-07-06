<?php

use App\Models\NatureFrais;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('natureFrais', function (Blueprint $table) {
            $table->id();
            $table->string('titleFrais');
            $table->timestamps();
        });
        NatureFrais::insertDefaultRecords();
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('natureFrais');
    }
};
