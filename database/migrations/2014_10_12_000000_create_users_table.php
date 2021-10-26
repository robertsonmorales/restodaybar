<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_level_id')->index('user_level_id');
            $table->string('profile_image')->nullable();
            $table->string('profile_image_updated_at')->nullable();
            $table->timestamp('profile_image_expiration_date')->nullable();
            $table->text('first_name')->nullable();
            $table->text('last_name')->nullable();
            $table->string('username')->nullable();
            $table->text('contact_number')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('email_updated_at')->nullable();
            $table->text('password')->nullable();
            $table->timestamp('password_updated_at')->nullable();
            $table->timestamp('password_expiration_date')->nullable();
            $table->string('old_password')->nullable(); 
            $table->string('temporary_password')->nullable();
            $table->text('address')->nullable();
            $table->enum('account_status', [1, 2, 3])->default(1); // active = 1, deactivated = 2, locked = 3, 
            $table->ipAddress('ip')->nullable();
            $table->macAddress('device')->nullable();
            $table->string('last_active_at')->nullable(); // null = offline, < 5 mins = idle, !5mins = online
            $table->rememberToken();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
