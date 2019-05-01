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
            $table->unsignedBigInteger('chemist_id')->nullable();
            $table->foreign('chemist_id')->references('id')->on('chemists');
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
