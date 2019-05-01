<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalysisRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analysis_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('parameter');
            $table->string('method');
            $table->decimal('fee', 8, 2);
            $table->unsignedBigInteger('feed_analysis_test_id');
            $table->foreign('feed_analysis_test_id')->references('id')->on('feed_analysis_tests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analysis_requests');
    }
}
