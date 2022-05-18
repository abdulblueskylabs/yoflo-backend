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
        $table->unsignedBigInteger('yoflo_id');
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('node_type_id');
        $table->string('title');
        $table->string('description')->nullable();
        $table->string('coordinates');
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
