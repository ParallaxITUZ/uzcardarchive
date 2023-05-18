<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->integer('region_id');
            $table->integer('parent_id')->nullable();
            $table->integer('organization_type_id');
            $table->integer('company_number');
            $table->integer('filial_number');
            $table->integer('branch_number');
            $table->integer('agent_number');
            $table->integer('sub_agent_number');
            $table->integer('inn')->nullable();
            $table->string('account');
            $table->string('address');
            $table->string('director_fio');
            $table->string('director_phone');
            $table->integer('status')->default(10);
            $table->boolean('is_deleted')->default(false);

            $table->foreign('region_id')->references('id')->on('dictionary_items');
            $table->foreign('parent_id')->references('id')->on('organizations');
            $table->foreign('organization_type_id')->references('id')->on('dictionary_items');

            $table->unique(['company_number', 'filial_number', 'branch_number', 'agent_number', 'sub_agent_number']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}
