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
        Schema::create('arhead', function (Blueprint $table) {
            $table->id();
            $table->double('amount', 8, 2)->default('0');
            $table->double('transaction_charge', 8, 2)->default('0');
            $table->integer('row_sign');
            $table->foreignId('tracking_history_id')->references('id')->on('tracking_history')->onDelete('cascade');
            $table->foreignId('wallet_id')->references('id')->on('wallet')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('arhead');
    }
};
