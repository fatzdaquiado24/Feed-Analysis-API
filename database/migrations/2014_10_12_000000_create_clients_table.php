<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('address');
            $table->string('cellphone_number');
            $table->string('email');
            $table->string('password');
            $table->enum('status', ['Email confirmation', 'For approval', 'Approved', 'Denied']);
            $table->string('activation_token')->nullable();
            $table->enum('client_type', ['Student', 'Farm Owner', 'Business Owner']);
            $table->string('valid_id');
            $table->string('business_permit')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
