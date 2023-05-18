<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('re_contracts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('old_contract_id');
            $table->integer('new_contract_id');
            $table->integer('reason_id');
            $table->string('comment')->nullable();

            $table->foreign('old_contract_id')->references('id')->on('client_contracts');
            $table->foreign('new_contract_id')->references('id')->on('client_contracts');
            $table->foreign('reason_id')->references('id')->on('dictionary_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('re_contracts');
    }
}
