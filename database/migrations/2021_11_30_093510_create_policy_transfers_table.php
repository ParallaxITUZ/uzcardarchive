<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolicyTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policy_transfers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('from_warehouse_id');
            $table->integer('to_warehouse_id');
            $table->integer('policy_request_id');
            $table->integer('status')->default(1);
        });
        Schema::create('policy_transfer_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('policy_transfer_id');
            $table->integer('from_warehouse_item_id');
            $table->integer('to_warehouse_item_id');
            $table->integer('policy_id');
            $table->string('series');
            $table->integer('number_from');
            $table->integer('number_to');
            $table->integer('axo_user_id');
            $table->integer('request_item_id');
            $table->integer('amount');
            $table->integer('type')->nullable();
            $table->integer('status')->default(1);

            $table->foreign('request_item_id')->references('id')->on('policy_request_items');
            $table->foreign('axo_user_id')->references('id')->on('users');
            $table->foreign('policy_transfer_id')->references('id')->on('policy_transfers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('policy_transfer_items');
        Schema::dropIfExists('policy_transfers');
    }
}
