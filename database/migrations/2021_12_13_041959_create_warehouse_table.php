<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('organization_id');
            $table->integer('status')->default(1);
            $table->boolean('is_deleted')->default(false);

            $table->foreign('organization_id')->references('id')->on('organizations');
        });

        Schema::create('warehouse_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('warehouse_id');
            $table->integer('policy_id');
            $table->string('series');
            $table->integer('number_from');
            $table->integer('number_to');
            $table->integer('amount');
            $table->integer('status')->default(1);
            $table->boolean('is_deleted')->default(false);

            $table->foreign('warehouse_id')->references('id')->on('warehouses');
        });

        Schema::table('policy_transfers', function (Blueprint $table) {
            $table->foreign('from_warehouse_id')->references('id')->on('warehouses');
            $table->foreign('to_warehouse_id')->references('id')->on('warehouses');
        });
        Schema::table('policy_transfer_items', function (Blueprint $table) {
            $table->foreign('from_warehouse_item_id')->references('id')->on('warehouse_items');
            $table->foreign('to_warehouse_item_id')->references('id')->on('warehouse_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('policy_transfers', function($table) {
            $table->dropForeign(['from_warehouse_id']);
            $table->dropForeign(['to_warehouse_id']);
        });
        Schema::table('policy_transfer_items', function($table) {
            $table->dropForeign(['from_warehouse_item_id']);
            $table->dropForeign(['to_warehouse_item_id']);
        });
        Schema::dropIfExists('warehouse_items');
        Schema::dropIfExists('warehouses');
    }
}
