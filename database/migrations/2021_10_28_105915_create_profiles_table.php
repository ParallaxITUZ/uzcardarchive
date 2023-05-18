<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->timestamps();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('pinfl')->nullable();
            $table->string('phone');
            $table->integer('region_id');
            $table->integer('user_id')->primary();
            $table->integer('organization_id');
            $table->integer('position_id')->nullable();
            $table->integer('status')->default(10);
            $table->boolean('is_deleted')->default(false);

            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('position_id')->references('id')->on('dictionary_items');
            $table->foreign('region_id')->references('id')->on('dictionary_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
