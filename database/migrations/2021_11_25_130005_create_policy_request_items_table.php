<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolicyRequestItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policy_request_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('policy_request_id');
            $table->integer('policy_id');
            $table->integer('amount');
            $table->integer('approved_amount')->default(0);
            $table->integer('status')->default(0);
            $table->boolean('is_deleted')->default(false);

            $table->foreign('policy_request_id')->references('id')->on('policy_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('policy_request_items');
    }
}
