<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedAnalysisTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_analysis_tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sample_name');
            $table->unsignedBigInteger('laboratory_analysis_request_id');
            $table->foreign('laboratory_analysis_request_id')->references('id')->on('laboratory_analysis_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed_analysis_tests');
    }
}
