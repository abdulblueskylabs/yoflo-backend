<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  return new class extends Migration {
    /**
     * Run the migrations.
     * @return void
     */
    public function up ()
    {
      Schema::create('files', function (Blueprint $table) {
        $table->id();
        $table->string('type');
        $table->decimal('size');
        $table->string('path');
        $table->string('url');
        $table->string('extension');
        $table->string('name');
        $table->string('reference');
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('node_id');
        $table->foreign('user_id')
          ->unsigned()
          ->references('id')
          ->on('users');
        $table->foreign('node_id')
          ->unsigned()
          ->references('id')
          ->on('nodes');
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down ()
    {
      Schema::dropIfExists('files');
    }
  };
