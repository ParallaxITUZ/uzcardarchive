<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_contracts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('organization_id');
            $table->integer('user_id');
            $table->date('date_from');
            $table->date('date_to');
            $table->string('number');
            $table->double('commission');
            $table->string('signer');
            $table->string('status')->default(1);

            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent_contracts');
    }
}
