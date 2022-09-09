<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElecetionCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elecetion_candidates', function (Blueprint $table) {
            $table->unsignedBigInteger('election_id');
            $table->unsignedBigInteger('camdidate_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elecetion_candidates');
    }
}
