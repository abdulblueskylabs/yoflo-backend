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
      Schema::create('shares', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('yoflo_id');
        $table->unsignedBigInteger('shared_user_id');
        $table->string('status');
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
      Schema::dropIfExists('shares');
    }
  };
