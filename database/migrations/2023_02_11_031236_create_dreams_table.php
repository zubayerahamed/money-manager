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
            $table->double('amount_needed', 8, 2)->default('0');
            $table->double('achieve_amount', 8, 2)->default('0');
            $table->boolean('active')->default(true);
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->nullable(false);
            $table->unique(['name', 'user_id']);
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
        Schema::dropIfExists('dreams');
    }
};
