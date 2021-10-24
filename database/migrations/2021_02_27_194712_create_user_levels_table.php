<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('modules')->nullable()->comment('parent navigation IDs');
            $table->string('sub_modules')->nullable()->comment('child navigation IDs');
            $table->string('create')->nullable();
            $table->string('edit')->nullable();
            $table->string('delete')->nullable();
            $table->string('import')->nullable();
            $table->string('export')->nullable();
            $table->enum('status', [1, 0])->default(1)->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('user_levels');
    }
}
