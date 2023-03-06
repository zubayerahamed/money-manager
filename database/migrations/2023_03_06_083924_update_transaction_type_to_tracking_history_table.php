<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table('tracking_history', function (Blueprint $table) {
            DB::statement("ALTER TABLE `tracking_history` CHANGE `transaction_type` `transaction_type` ENUM('INCOME', 'EXPENSE', 'TRANSFER', 'OPENING','SAVING') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tracking_history', function (Blueprint $table) {
            //
        });
    }
};
