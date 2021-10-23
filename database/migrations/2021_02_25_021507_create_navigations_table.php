<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigations', function (Blueprint $table) {
            $table->id();
            $table->string('nav_type')->nullable();
            $table->string('nav_name')->nullable();
            $table->string('nav_route')->nullable();
            $table->string('nav_controller')->nullable();
            $table->string('nav_icon')->nullable();
            $table->integer('nav_order')->nullable();
            $table->integer('nav_suborder')->nullable();
            $table->integer('nav_childs_parent_id')->nullable();
            $table->integer('status')->default(1)->comment('1 = active; 0 = inactive');
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
        Schema::dropIfExists('navigations');
    }
}
