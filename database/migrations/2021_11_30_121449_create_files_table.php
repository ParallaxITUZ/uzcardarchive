<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('user_id');
            $table->string('type');
            $table->string('filename');
            $table->string('path');
            $table->string('extension');
            $table->string('size');

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organization_contracts', function (Blueprint $table) {
            $table->dropForeign(['file_id']);
        });
        Schema::table('agent_contracts', function (Blueprint $table) {
            $table->dropForeign(['file_id']);
        });
        Schema::dropIfExists('files');
    }
}
