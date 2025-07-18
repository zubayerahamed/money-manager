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
        Schema::create('dreams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable(true);
            $table->integer('target_year');
            $table->float('amount_needed', 15, 2)->default('0');
            $table->text('note')->nullable();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->nullable(false);
            $table->foreignId('wallet_id')->nullable()->references('id')->on('wallet')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['name', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dreams');
    }
};
