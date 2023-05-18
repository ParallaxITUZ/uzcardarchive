<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('dictionary_insurance_object_id');
            $table->integer('insurance_form_id');
            $table->integer('insurance_type_id');
            $table->integer('period_type_id');
            $table->integer('currency_id');
            $table->boolean('single_payment');
            $table->boolean('multi_payment');
            $table->float('tariff_scale_from');
            $table->float('tariff_scale_to');
            $table->integer('policy_id');
            $table->integer('status')->default(1);
            $table->boolean('is_deleted')->default(false);

            $table->foreign('dictionary_insurance_object_id')->references('id')->on('dictionary_items');
            $table->foreign('insurance_form_id')->references('id')->on('dictionary_items');
            $table->foreign('insurance_type_id')->references('id')->on('dictionary_items');
            $table->foreign('period_type_id')->references('id')->on('dictionary_items');
            $table->foreign('currency_id')->references('id')->on('dictionary_items');

//            $table->unique(['name']);
        });

        Schema::create('product_tariffs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('product_id');
            $table->integer('status')->default(1);
            $table->boolean('is_deleted')->default(false);

            $table->foreign('product_id')->references('id')->on('products');

//            $table->unique(['name', 'product_id']);
        });

        Schema::create('product_tariff_risks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('product_tariff_id');
            $table->string('name');
            $table->float('amount');
            $table->boolean('is_deleted')->default(false);

            $table->foreign('product_tariff_id')->references('id')->on('product_tariffs');

//            $table->unique(['name', 'product_tariff_id']);
        });

        Schema::create('product_tariff_conditions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('dictionary_item_id');
            $table->integer('product_tariff_id');
            $table->boolean('is_deleted')->default(false);

            $table->foreign('dictionary_item_id')->references('id')->on('dictionary_items');
            $table->foreign('product_tariff_id')->references('id')->on('product_tariffs');

//            $table->unique(['dictionary_item_id', 'product_tariff_id']);
        });


        Schema::create('product_tariff_bonuses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('product_tariff_condition_id');
            $table->integer('dictionary_item_id');
            $table->string('name');
            $table->string('value');
            $table->integer('status')->default(1);
            $table->boolean('is_deleted')->default(false);

            $table->foreign('product_tariff_condition_id')->references('id')->on('product_tariff_conditions');
            $table->foreign('dictionary_item_id')->references('id')->on('dictionary_items');
        });


        Schema::create('product_tariff_configurations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('product_tariff_id');
            $table->integer('dictionary_item_id');
            $table->float('option_from');
            $table->float('option_to');
            $table->float('value');
            $table->integer('status')->default(1);
            $table->boolean('is_deleted')->default(false);

            $table->foreign('product_tariff_id')->references('id')->on('product_tariffs');
            $table->foreign('dictionary_item_id')->references('id')->on('dictionary_items');

//            $table->unique(['dictionary_item_id', 'product_tariff_id']);
        });

        Schema::create('product_insurance_classes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('product_id');
            $table->integer('insurance_class_id');
            $table->boolean('is_deleted')->default(false);

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('insurance_class_id')->references('id')->on('dictionary_items');

//            $table->unique(['product_id', 'insurance_class_id']);
        });

        Schema::create('product_periods', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('product_id');
            $table->float('period_from');
            $table->float('period_to');
            $table->boolean('is_deleted')->default(false);

            $table->foreign('product_id')->references('id')->on('products');

//            $table->unique(['product_id', 'period_from', 'period_to']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_tariffs', function($table) {
            $table->dropForeign(['product_id']);
        });
        Schema::table('product_insurance_classes', function($table) {
            $table->dropForeign(['product_id']);
        });
        Schema::table('product_periods', function($table) {
            $table->dropForeign(['product_id']);
        });
        Schema::table('product_tariff_conditions', function($table) {
            $table->dropForeign(['product_tariff_id']);
        });
        Schema::table('product_tariff_configurations', function($table) {
            $table->dropForeign(['product_tariff_id']);
        });
        Schema::table('product_tariff_risks', function($table) {
            $table->dropForeign(['product_tariff_id']);
        });
        Schema::table('product_tariff_bonuses', function($table) {
            $table->dropForeign(['product_tariff_condition_id']);
        });
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_tariffs');
        Schema::dropIfExists('product_tariff_risks');
        Schema::dropIfExists('product_tariff_conditions');
        Schema::dropIfExists('product_tariff_bonuses');
        Schema::dropIfExists('product_tariff_configurations');
        Schema::dropIfExists('product_insurance_classes');
        Schema::dropIfExists('product_periods');
    }
}
