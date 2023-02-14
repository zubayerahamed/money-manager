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
        Schema::create('acount_tracking_histories', function (Blueprint $table) {
            $table->id();
            $table->enum('transaction_type', ['IN', 'OUT']);
            $table->double('amount', 8, 2)->default('0');
            $table->double('transaction_charge', 8, 2)->default('0');
            $table->foreignId('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->date('transaction_date');
            $table->time('transaction_time', $precision = 0);
            $table->text('note')->nullable();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('month');
            $table->integer('year');
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
        Schema::dropIfExists('acount_tracking_histories');
    }
};
