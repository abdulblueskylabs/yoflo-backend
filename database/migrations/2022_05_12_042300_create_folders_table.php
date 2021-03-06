<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folders', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('user_id');
          $table->string('name');
          $table->unsignedBigInteger('parent_folder_id')->nullable();
          $table->foreign('parent_folder_id')
            ->nullabe()
            ->unsigned()
            ->references('id')
            ->on('folders');
          $table->foreign('user_id')
            ->unsigned()
            ->references('id')
            ->on('users');
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
        Schema::dropIfExists('folders');
    }
};
