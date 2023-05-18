<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateClientContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_contracts', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('user_id')->nullable();
            $table->integer('product_tariff_id');
            $table->date('begin_date');
            $table->date('end_date');
            $table->json('configurations');
            $table->integer('client_id');
            $table->integer('contract_id')->default(random_int(10000000, 99999999));
            $table->json('objects');
            $table->float('amount');
            $table->float('risks_sum')->nullable();
            $table->integer('file_id')->nullable();
            $table->integer('status')->default(0);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('product_tariff_id')->references('id')->on('product_tariffs');
            $table->foreign('file_id')->references('id')->on('files');
            $table->index('contract_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_contracts');
    }
}
