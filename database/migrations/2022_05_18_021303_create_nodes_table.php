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
      Schema::create('nodes', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('description')->nullable();
        $table->string('coordinates');
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('node_type_id');
        $table->unsignedBigInteger('yoflo_id');
        $table->foreign('user_id')
          ->unsigned()
          ->references('id')
          ->on('users');
        $table->foreign('node_type_id')
          ->unsigned()
          ->references('id')
          ->on('node_types');
        $table->foreign('yoflo_id')
          ->unsigned()
          ->references('id')
          ->on('yoflos');

        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down ()
    {
      Schema::dropIfExists('nodes');
    }
  };
