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
        Schema::create('tracking_history', function (Blueprint $table) {
            $table->id();
            $table->enum('transaction_type', ['INCOME', 'EXPENSE', 'TRANSFER', 'OPENING']);
            $table->double('amount', 8, 2)->default('0');
            $table->double('transaction_charge', 8, 2)->default('0');
            $table->foreignId('from_wallet')->nullable()->references('id')->on('wallet')->onDelete('cascade');
            $table->foreignId('to_wallet')->nullable()->references('id')->on('wallet')->onDelete('cascade');
            $table->foreignId('income_source')->nullable()->references('id')->on('income_source')->onDelete('cascade');
            $table->foreignId('expense_type')->nullable()->references('id')->on('expense_type')->onDelete('cascade');
            $table->date('transaction_date');
            $table->time('transaction_time', $precision = 0);
            $table->text('note')->nullable();
            $table->foreignId('user_id');
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
        Schema::dropIfExists('tracking_history');
    }
};
