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
      Schema::create('libraries', function (Blueprint $table) {
        $table->id();
        $table->string('type');
        $table->string('size');
        $table->string('path');
        $table->string('url');
        $table->string('extension');
        $table->string('name');
        $table->string('reference');
        $table->unsignedBigInteger('node_id');
        $table->unsignedBigInteger('user_id');
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down ()
    {
      Schema::dropIfExists('libraries');
    }
  };
