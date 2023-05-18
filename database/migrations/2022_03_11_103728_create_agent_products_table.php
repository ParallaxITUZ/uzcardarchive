<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_products', function (Blueprint $table) {
            $table->unsignedBigInteger('agent_id');
            $table->unsignedBigInteger('product_id');

            $table->foreign('product_id')->references('id')->on('products')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('agent_id')->references('id')->on('organizations')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['agent_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent_products');
    }
}
