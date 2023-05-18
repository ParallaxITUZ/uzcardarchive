<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_datas', function (Blueprint $table) {
            $table->string('pinfl')->nullable();
            $table->integer('organization_id')->primary();
            $table->integer('agent_type_id');

            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('agent_type_id')->references('id')->on('dictionary_items');

//            $table->unique(['pinfl']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent_datas');
    }
}
