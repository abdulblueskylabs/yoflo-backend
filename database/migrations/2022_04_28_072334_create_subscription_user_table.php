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
        Schema::create('subscription_user', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('subscription_id');
            $table->date('start');
            $table->date('end');
            $table->boolean('is_active');
            $table->dateTime('lote_deleted');
            $table->integer('lote_deleted_by');
            $table->integer('lote_author_id');
            $table->integer('lote_access');
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
        Schema::dropIfExists('subscription_user');
    }
};
