<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditTrailLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_trail_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('route')->nullable();
            $table->string('module')->nullable();
            $table->string('method')->nullable();
            $table->text('remarks')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->macAddress('device', 36)->nullable();
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
        Schema::dropIfExists('audit_trail_logs');
    }
}
