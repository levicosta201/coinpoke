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
        Schema::create('log_buy', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('pokemon_id');
            $table->string('experience');
            $table->string('coin_price');
            $table->enum('operation', [
                'buy',
                'sell'
            ]);
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
        Schema::dropIfExists('log_buy');
    }
};
