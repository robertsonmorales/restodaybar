<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBrowserSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_browser_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index('user_id');
            $table->string('device_family')->nullable();
            $table->string('device_model')->nullable();
            $table->string('plaform_family')->nullable();
            $table->string('plaform_name')->nullable();
            $table->string('browser')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->macAddress('mac_address')->nullable();
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
        Schema::dropIfExists('user_browser_sessions');
    }
}
