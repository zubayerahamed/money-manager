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
        Schema::create('transaction_history_details', function (Blueprint $table) {
            $table->id();
            $table->double('amount', 8, 2)->default('0');
            $table->date('transaction_date');
            $table->time('transaction_time', $precision = 0);
            $table->foreignId('sub_expense_type_id')->references('id')->on('sub_expense_types')->onDelete('cascade');
            $table->foreignId('tracking_history_id')->references('id')->on('tracking_history')->onDelete('cascade');
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
        Schema::dropIfExists('transaction_history_details');
    }
};
