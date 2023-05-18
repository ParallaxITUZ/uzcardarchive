<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolicyRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policy_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('sender_id');
            $table->integer('receiver_id');
            $table->integer('requested_user_id');
            $table->integer('approved_user_id')->nullable();
            $table->timestamp('delivery_date');
            $table->text('comment')->nullable();
            $table->integer('status')->default(0);
            $table->boolean('is_deleted')->default(false);

            $table->foreign('sender_id')->references('id')->on('organizations');
            $table->foreign('receiver_id')->references('id')->on('organizations');
            $table->foreign('requested_user_id')->references('id')->on('users');
            $table->foreign('approved_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('policy_requests');
    }
}
