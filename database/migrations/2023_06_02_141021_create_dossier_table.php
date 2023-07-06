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
        Schema::create('dossier', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')->references('id')->on('members');
            $table->unsignedBigInteger('nature_id')->nullable();
            $table->foreign('nature_id')->references('id')->on('nature_juridiction');
            $table->string('votreReference');
            $table->string('typeJuridiction');
            $table->string('villeJuridiction');
            $table->string('sectionJuridiction');
            $table->longText('jugeRapporteur')->nullable();
            $table->string('etatProcedurale');
            $table->date('dateEtatProcedurale');
            $table->string('numDecision')->nullable();
            $table->string('dateDecision')->nullable();
            $table->string('numJuridiction');
            $table->string('status')->default('0');
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
        Schema::dropIfExists('dossier');
    }
};
