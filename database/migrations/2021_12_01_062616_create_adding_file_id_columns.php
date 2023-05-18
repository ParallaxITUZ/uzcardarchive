<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddingFileIdColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organization_contracts', function (Blueprint $table) {
            $table->integer('file_id');

            $table->foreign('file_id')->references('id')->on('files');
        });
        Schema::table('agent_contracts', function (Blueprint $table) {
            $table->integer('file_id');

            $table->foreign('file_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
