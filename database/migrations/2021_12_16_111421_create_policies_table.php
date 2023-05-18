<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->json('display_name');
            $table->string('series');
            $table->tinyInteger('form');
            $table->boolean('status')->default(1);
            $table->boolean('is_deleted')->default(false);

//            $table->unique(['name', 'series']);
        });

        Schema::table('policy_request_items', function (Blueprint $table) {
            $table->foreign('policy_id')->references('id')->on('policies');
        });
        Schema::table('policy_transfer_items', function (Blueprint $table) {
            $table->foreign('policy_id')->references('id')->on('policies');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('policy_id')->references('id')->on('policies');
        });
        Schema::table('warehouse_items', function (Blueprint $table) {
            $table->foreign('policy_id')->references('id')->on('policies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('policy_request_items', function($table) {
            $table->dropForeign(['policy_id']);
        });
        Schema::table('policy_transfer_items', function($table) {
            $table->dropForeign(['policy_id']);
        });
        Schema::table('products', function($table) {
            $table->dropForeign(['policy_id']);
        });
        Schema::table('warehouse_items', function($table) {
            $table->dropForeign(['policy_id']);
        });
        Schema::dropIfExists('policies');
    }
}
