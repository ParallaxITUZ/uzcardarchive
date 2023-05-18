<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictionaryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictionary_items', function (Blueprint $table) {
            $table->id();
            $table->integer('dictionary_id');
            $table->integer('parent_id')->nullable();
            $table->integer('order')->nullable();
            $table->string('name')->nullable();
            $table->json('display_name');
            $table->json('description')->nullable();
            $table->string('value')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();

            $table->foreign('dictionary_id')->references('id')->on('dictionaries');

            $table->foreign('parent_id')->references('id')->on('dictionary_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dictionary_items', function($table) {
            $table->dropForeign(['parent_id']);
        });
        Schema::dropIfExists('dictionary_items');
    }
}
