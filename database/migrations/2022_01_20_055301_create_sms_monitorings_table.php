<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsMonitoringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_monitorings', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->integer('code');
            $table->integer('status')->default(200);
            $table->integer('expire_at')->default(120);
            $table->string('module')->nullable();
            $table->string('message_id');
            $table->integer('is_verified')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_monitorings');
    }
}
