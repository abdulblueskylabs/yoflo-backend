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
      Schema::create('user_subscription', function (Blueprint $table) {
        $table->id();
        $table->date('start_date');
        $table->date('end_date')->nullable();
        $table->boolean('is_active');
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('subscription_id');
        $table->foreign('user_id')
          ->unsigned()
          ->references('id')
          ->on('users');
        $table->foreign('subscription_id')
          ->nullabe()
          ->unsigned()
          ->references('id')
          ->on('subscriptions');
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down ()
    {
      Schema::dropIfExists('user_subscription');
    }
  };
