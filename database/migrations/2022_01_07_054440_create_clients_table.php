<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->integer('entity_type_id');
            $table->string('address');
            $table->string('phone');
            $table->integer('registered_user_id')->nullable();
            $table->timestamps();

            $table->foreign('entity_type_id')->references('id')->on('dictionary_items');
            $table->foreign('registered_user_id')->references('id')->on('dictionary_items');
        });

        Schema::create('legal_client_datas', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->string('name');
            $table->string('inn')->unique();
            $table->string('company');
            $table->integer('activity_id')->nullable();
            $table->string('okonx');
            $table->string('director_fish');
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('activity_id')->references('id')->on('dictionary_items');
        });

        Schema::create('individual_client_datas', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name');
            $table->string('passport_seria');
            $table->string('passport_number');
            $table->string('pinfl')->unique();
            $table->string('passport_issued_by')->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->date('birthday');
            $table->string('gender')->nullable();
            $table->string('region_id')->nullable();
            $table->string('district_id')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('legal_client_datas');
        Schema::dropIfExists('individual_client_datas');
        Schema::dropIfExists('clients');
    }
}
