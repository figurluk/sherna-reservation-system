<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToReservation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sherna_reservations',function(Blueprint $table){
            $table->unsignedInteger('visitors_count')->nullable();
            $table->unsignedInteger('console_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sherna_reservations',function(Blueprint $table){
            $table->dropColumn('visitors_count');
            $table->dropColumn('console_id');
        });
    }
}
