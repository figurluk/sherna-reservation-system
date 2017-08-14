<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnteredColumnToReservation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('sherna_reservations',function (Blueprint $table) {
            $table->timestamp('entered_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::table('sherna_reservations',function (Blueprint $table) {
            $table->dropColumn('entered_at');
            $table->dropColumn('canceled_at');
        });
    }
}
