<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdsLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('sherna_locations', function (Blueprint $table) {
            $table->string('reader_uid')->nullable();
            $table->string('location_uid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::table('sherna_locations', function (Blueprint $table) {
            $table->dropColumn('reader_uid');
            $table->dropColumn('location_uid');
        });
    }
}
