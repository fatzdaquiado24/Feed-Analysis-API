<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConstraintToLaboratoryAnalysisRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laboratory_analysis_requests', function (Blueprint $table) {
            $table->dropForeign(['laboratory_analysis_request_id']);
            $table->foreign('laboratory_analysis_request_id')->references('id')->on('laboratory_analysis_requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laboratory_analysis_requests', function (Blueprint $table) {
            //
        });
    }
}
